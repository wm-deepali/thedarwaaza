<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Format;
use Illuminate\Validation\Rule;
use Illuminate\Http\UploadedFile;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;

class CategoryController extends Controller
{
    // Slugs that already belong to fixed routes (catch-all /{slug} must not override them)
    private const RESERVED_SLUGS = [
        'index',
        'about',
        'contact',
        'enquiry',
        'strength',
        'admin',
        'login',
        'logout',
        'register',
        'storage',
        'api',
    ];

    // ✅ List
    public function index(Request $request)
    {
        $query = Category::with('parent')->withCount('children');

        // Parent filter dropdown (only categories that have children)
        $parentCategories = Category::whereHas('children')->orderBy('name')->get();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->type == 'category') {
            $query->whereNull('parent_id');
        } elseif ($request->type == 'subcategory') {
            $query->whereNotNull('parent_id');

            if ($request->filled('category_id')) {
                $query->where('parent_id', $request->category_id);
            }
        }

        $sortBy = $request->get('sort_by', 'id');
        $sortOrder = in_array($request->get('sort_order'), ['asc', 'desc']) ? $request->sort_order : 'desc';

        if (in_array($sortBy, ['id', 'name', 'sort_order', 'status', 'show_in_navbar'])) {
            $query->orderBy($sortBy, $sortOrder);
        }

        $categories = $query->paginate(10)->appends($request->all());

        return view('admin.categories.index', compact('categories', 'parentCategories'));
    }

    // ✅ Create
    public function create()
    {
        $parents = Category::orderBy('name')->get();

        return view('admin.categories.create', compact('parents'));
    }

    // ✅ Store
    public function store(Request $request)
    {
        $this->prepareSlug($request);
        $request->validate($this->rules(), $this->messages());

        if ($this->parentHasProducts($request)) {
            return back()
                ->withErrors(['parent_id' => 'This category already has products. Remove them before adding sub categories under it.'])
                ->withInput();
        }

        $data = $this->payload($request);

        if ($request->hasFile('image')) {
            $data['image'] = $this->compressAndStore($request->file('image'), 'categories', 800, 80);
        }

        if ($request->hasFile('banner_image')) {
            $data['banner_image'] = $this->compressAndStore($request->file('banner_image'), 'categories/banners', 1600, 80);
        }

        Category::create($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category Added Successfully');
    }

    // ✅ Edit
    public function edit(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        // Can't pick itself or its own children as parent
        $exclude = array_merge([$category->id], $category->descendantIds());

        $parents = Category::whereNotIn('id', $exclude)->orderBy('name')->get();

        $redirect = $request->redirect;

        return view('admin.categories.edit', compact('category', 'parents', 'redirect'));
    }

    // ✅ Update
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $this->prepareSlug($request);
        $request->validate($this->rules($category), $this->messages());

        if ($request->filled('parent_id')) {
            $blocked = array_merge([$category->id], $category->descendantIds());

            if (in_array((int) $request->parent_id, $blocked, true)) {
                return back()
                    ->withErrors(['parent_id' => 'A category cannot be moved under itself or its own sub category.'])
                    ->withInput();
            }
        }

        if ($this->parentHasProducts($request)) {
            return back()
                ->withErrors(['parent_id' => 'This category already has products. Remove them before adding sub categories under it.'])
                ->withInput();
        }

        $data = $this->payload($request);

        $data['image'] = $this->replaceImage($request, 'image', $category->image, 'categories', 800);
        $data['banner_image'] = $this->replaceImage($request, 'banner_image', $category->banner_image, 'categories/banners', 1600);

        $category->update($data);

        $redirect = $request->redirect;
        $safe = $redirect && Str::startsWith($redirect, url('/'));

        return redirect($safe ? $redirect : route('admin.categories.index'))
            ->with('success', 'Category Updated Successfully');
    }

    // ✅ Delete
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        if ($category->children()->exists()) {
            return response()->json([
                'message' => 'This category has sub categories. Delete or move them first.'
            ], 422);
        }

        if ($category->products()->exists()) {
            return response()->json([
                'message' => 'This category has products. Delete them first.'
            ], 422);
        }

        foreach ([$category->image, $category->banner_image] as $file) {
            if ($file && Storage::disk('public')->exists($file)) {
                Storage::disk('public')->delete($file);
            }
        }

        $category->delete();

        return response()->json(['message' => 'Category Deleted Successfully']);
    }

    /* ───────────────────────── helpers ───────────────────────── */

    private function prepareSlug(Request $request): void
    {
        $request->merge([
            'slug' => Str::slug($request->slug ?: $request->name),
        ]);
    }

    // A category that already holds products can't also get sub categories
    private function parentHasProducts(Request $request): bool
    {
        return $request->filled('parent_id')
            && Product::where('category_id', $request->parent_id)->exists();
    }

    private function rules(?Category $category = null): array
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'slug')->ignore($category?->id),
                Rule::notIn(self::RESERVED_SLUGS),
            ],
            'parent_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|mimes:jpg,jpeg,png,webp|max:2048',
            'banner_image' => 'nullable|mimes:jpg,jpeg,png,webp|max:4096',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'canonical_url' => 'nullable|url|max:255',
            'sort_order' => 'nullable|integer|min:0',
        ];
    }

    private function messages(): array
    {
        return [
            'slug.not_in' => 'This slug is reserved for a fixed page. Please use another one.',
        ];
    }

    private function payload(Request $request): array
    {
        return [
            'name' => $request->name,
            'slug' => $request->slug,
            'parent_id' => $request->parent_id ?: null,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords,
            'canonical_url' => $request->canonical_url,
            'sort_order' => $request->sort_order ?? 0,
            'show_in_navbar' => $request->boolean('show_in_navbar'),
            'status' => $request->boolean('status'),
        ];
    }

    // Keeps old file if nothing new is uploaded, otherwise deletes old + stores new
    private function replaceImage(Request $request, string $field, ?string $old, string $folder, int $maxWidth): ?string
    {
        if (!$request->hasFile($field)) {
            return $old;
        }

        if ($old && Storage::disk('public')->exists($old)) {
            Storage::disk('public')->delete($old);
        }

        return $this->compressAndStore($request->file($field), $folder, $maxWidth, 80);
    }

    /**
     * Resize down (never upscale) and store as WebP.
     */
    private function compressAndStore(UploadedFile $file, string $folder, int $maxWidth = 1200, int $quality = 80): string
    {
        $manager = ImageManager::usingDriver(Driver::class);

        $image = $manager->decode($file);

        if ($image->width() > $maxWidth) {
            $image->scale(width: $maxWidth);
        }

        $encoded = $image->encodeUsingFormat(Format::WEBP, quality: $quality);

        $path = trim($folder, '/') . '/' . Str::uuid() . '.webp';

        Storage::disk('public')->put($path, (string) $encoded);

        return $path;
    }

    // ✅ Add many categories at once (one name per line)
    public function storeBulk(Request $request)
    {
        $request->validate([
            'names' => ['required', 'string'],
            'parent_id' => ['nullable', 'exists:categories,id'],
            'status' => ['nullable', 'boolean'],
            'show_in_navbar' => ['nullable', 'boolean'],
        ], [
            'names.required' => 'Enter at least one category name.',
        ]);

        if ($this->parentHasProducts($request)) {
            return back()
                ->withErrors(['parent_id' => 'This category already has products. Remove them before adding sub categories under it.'])
                ->withInput();
        }

        // One name per line, trimmed, blanks and repeated lines removed
        $names = collect(preg_split('/\r\n|\r|\n/', $request->names))
            ->map(fn($n) => trim($n))
            ->filter()
            ->unique(fn($n) => mb_strtolower($n))
            ->values();

        if ($names->isEmpty()) {
            return back()->withErrors(['names' => 'Enter at least one category name.'])->withInput();
        }

        if ($names->count() > 100) {
            return back()->withErrors(['names' => 'Add at most 100 categories at a time.'])->withInput();
        }

        $parentId = $request->parent_id ?: null;
        $sort = ((int) Category::where('parent_id', $parentId)->max('sort_order')) + 1;
        $created = 0;
        $skipped = [];

        foreach ($names as $name) {
            if (mb_strlen($name) > 255) {
                $skipped[] = "'" . Str::limit($name, 40) . "' is too long.";
                continue;
            }

            $exists = Category::where('parent_id', $parentId)
                ->whereRaw('LOWER(name) = ?', [mb_strtolower($name)])
                ->exists();

            if ($exists) {
                $skipped[] = "'{$name}' already exists here.";
                continue;
            }

            $base = Str::slug($name);
            if ($base === '') {
                $skipped[] = "'{$name}' has no usable letters or numbers for a URL.";
                continue;
            }

            // Unique slug, never a reserved one
            $slug = $base;
            $i = 2;
            while (in_array($slug, self::RESERVED_SLUGS, true) || Category::where('slug', $slug)->exists()) {
                $slug = $base . '-' . $i++;
            }

            Category::create([
                'name' => $name,
                'slug' => $slug,
                'parent_id' => $parentId,
                'sort_order' => $sort++,
                'show_in_navbar' => $request->boolean('show_in_navbar'),
                'status' => $request->boolean('status', true),
            ]);

            $created++;
        }

        Cache::forget('nav_categories');

        return redirect()->route('admin.categories.index')
            ->with($created ? 'success' : 'error', "{$created} categories added.")
            ->with('bulk_skipped', $skipped);
    }

}