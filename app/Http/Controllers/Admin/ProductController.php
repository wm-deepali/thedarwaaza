<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Format;

class ProductController extends Controller
{
    // ✅ List + upload page
    public function index(Request $request)
    {
        // Only categories WITHOUT sub categories can hold products
        $leafCategories = Category::whereDoesntHave('children')->orderBy('name')->get();

        $products = Product::with('category')
            ->when($request->filled('category_id'), fn ($q) => $q->where('category_id', $request->category_id))
            ->orderBy('category_id')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->paginate(24)
            ->appends($request->all());

        return view('admin.products.index', compact('leafCategories', 'products'));
    }

    // ✅ Bulk upload (many images at once)
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'images'      => 'required|array|min:1',
            'images.*'    => 'mimes:jpg,jpeg,png,webp|max:4096',
        ], [
            'images.required' => 'Please choose at least one image.',
            'images.*.mimes'  => 'Only JPG, PNG or WEBP images are allowed.',
            'images.*.max'    => 'Each image must be under 4 MB.',
        ]);

        $category = Category::findOrFail($request->category_id);

        if ($category->children()->exists()) {
            return back()
                ->withErrors(['category_id' => 'Products can only be added to a category without sub categories.'])
                ->withInput();
        }

        $order = (int) Product::where('category_id', $category->id)->max('sort_order');

        foreach ($request->file('images') as $file) {
            Product::create([
                'category_id' => $category->id,
                'image'       => $this->compressAndStore($file, 'products', 900, 80),
                'sort_order'  => ++$order,
                'status'      => 1,
            ]);
        }

        return redirect()
            ->route('admin.products.index', ['category_id' => $category->id])
            ->with('success', count($request->file('images')) . ' image(s) uploaded successfully');
    }

    // ✅ Update name / sort / status
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name'       => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $product->update([
            'name'       => $request->name,
            'sort_order' => $request->sort_order ?? 0,
            'status'     => $request->boolean('status'),
        ]);

        return back()->with('success', 'Product Updated Successfully');
    }

    // ✅ Delete
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return response()->json(['message' => 'Product Deleted Successfully']);
    }

    private function compressAndStore(UploadedFile $file, string $folder, int $maxWidth = 900, int $quality = 80): string
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
}