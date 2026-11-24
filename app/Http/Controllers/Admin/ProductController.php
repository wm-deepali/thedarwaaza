<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Format;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;

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

public function importTemplate()
{
    return response()->streamDownload(function () {
        $out = fopen('php://output', 'w');
        fputcsv($out, ['category', 'name', 'image', 'sort_order', 'status']);
        fputcsv($out, ['2d-membrane-door', 'Walnut Finish Door', 'door-01.jpg', 1, 1]);
        fputcsv($out, ['2d-membrane-door', 'Classic White Door', 'door-02.jpg', 2, 1]);
        fclose($out);
    }, 'products-import-template.csv', ['Content-Type' => 'text/csv']);
}

public function import(Request $request)
{
    $request->validate([
        'csv'      => ['required', 'file', 'mimes:csv,txt', 'max:5120'],
        'images'   => ['nullable', 'array'],
        'images.*' => ['image', 'mimes:png,jpg,jpeg,webp', 'max:5120'],
    ]);

    // Uploaded images, keyed by lowercase file name
    $files = [];
    foreach ($request->file('images', []) as $file) {
        $files[strtolower($file->getClientOriginalName())] = $file;
    }

    $handle = fopen($request->file('csv')->getRealPath(), 'r');
    $header = fgetcsv($handle);

    if (!$header) {
        return back()->with('import_errors', ['The CSV file is empty.']);
    }

    // Strip BOM (Excel adds it) and normalise headings
    $header[0] = preg_replace('/^\xEF\xBB\xBF/', '', $header[0]);
    $header    = array_map(fn ($h) => strtolower(trim($h)), $header);

    foreach (['category', 'image'] as $required) {
        if (!in_array($required, $header, true)) {
            return back()->with('import_errors', ["Missing required column: {$required}"]);
        }
    }

    $categoryCache = [];
    $storedImages  = [];   // same image used in many rows is saved once
    $created       = 0;
    $errors        = [];
    $line          = 1;

    while (($row = fgetcsv($handle)) !== false) {
        $line++;

        if (count(array_filter($row, fn ($v) => trim((string) $v) !== '')) === 0) {
            continue; // blank line
        }

        $row = array_pad($row, count($header), '');
        $row = array_combine($header, array_map('trim', array_slice($row, 0, count($header))));

        // ── Category: id, slug or name ───────────────────────────
        $key = $row['category'];
        if ($key === '') {
            $errors[] = "Row {$line}: category is empty.";
            continue;
        }

        if (!array_key_exists($key, $categoryCache)) {
            $categoryCache[$key] = Category::where('id', ctype_digit($key) ? (int) $key : 0)
                ->orWhere('slug', $key)
                ->orWhere('name', $key)
                ->first();
        }
        $category = $categoryCache[$key];

        if (!$category) {
            $errors[] = "Row {$line}: category '{$key}' not found.";
            continue;
        }

        // Products show only on categories without sub categories
        if (Category::where('parent_id', $category->id)->exists()) {
            $errors[] = "Row {$line}: '{$category->name}' has sub categories, use the last-level category.";
            continue;
        }

        // ── Image: matched by file name against the uploaded images ─
        $imageName = strtolower($row['image']);
        if ($imageName === '' || !isset($files[$imageName])) {
            $errors[] = "Row {$line}: image '{$row['image']}' was not uploaded with the CSV.";
            continue;
        }

        try {
            $storedImages[$imageName] ??= $files[$imageName]->store('products', 'public');

            Product::create([
                'category_id' => $category->id,
                'name'        => $row['name'] ?? null,
                'image'       => $storedImages[$imageName],
                'sort_order'  => is_numeric($row['sort_order'] ?? null) ? (int) $row['sort_order'] : 0,
                'status'      => in_array(strtolower($row['status'] ?? '1'), ['0', 'no', 'inactive'], true) ? 0 : 1,
            ]);

            $created++;
        } catch (\Throwable $e) {
            Log::error('Product import row failed', ['row' => $line, 'error' => $e->getMessage()]);
            $errors[] = "Row {$line}: could not be saved.";
        }
    }

    fclose($handle);

    return back()
        ->with($created ? 'success' : 'import_errors_only', "{$created} product(s) imported.")
        ->with('import_errors', $errors);
}

}