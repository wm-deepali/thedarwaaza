<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutItem;
use App\Models\AboutPage;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Format;
use Intervention\Image\ImageManager;

class AboutPageController extends Controller
{
    public function edit()
    {
        $page  = AboutPage::getInstance();
        $types = AboutItem::TYPES;

        $items = AboutItem::orderBy('sort_order')->orderBy('id')->get()->groupBy('type');

        return view('admin.about.edit', compact('page', 'types', 'items'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'banner_title'     => ['nullable', 'string', 'max:255'],
            'about_heading'    => ['nullable', 'string', 'max:255'],
            'about_content'    => ['nullable', 'string'],
            'why_heading'      => ['nullable', 'string', 'max:255'],
            'why_text'         => ['nullable', 'string'],
            'brochure_heading' => ['nullable', 'string', 'max:255'],
            'brochure_text'    => ['nullable', 'string'],
            'brochure_link'    => ['nullable', 'string', 'max:255'],
            'process_heading'  => ['nullable', 'string', 'max:255'],
            'about_image'      => ['nullable', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'brochure_image'   => ['nullable', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        $page = AboutPage::getInstance();

        foreach (['about_image' => 'about', 'brochure_image' => 'about'] as $field => $folder) {
            if ($request->hasFile($field)) {
                $this->deleteFile($page->{$field});
                $data[$field] = $this->compressAndStore($request->file($field), $folder, 1200);
            } else {
                unset($data[$field]);
            }
        }

        $page->update($data);

        return redirect()->route('admin.about-page.edit')->with('success', 'About page updated.');
    }

    public function itemStore(Request $request)
    {
        $type = $request->input('type');
        abort_unless(isset(AboutItem::TYPES[$type]), 422);

        $cfg = AboutItem::TYPES[$type];

        $data = $request->validate([
            'type'       => ['required'],
            'title'      => ['required', 'string', 'max:255'],
            'text'       => ['nullable', 'string', 'max:1000'],
            'icon'       => ['nullable', 'string', 'max:100'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'status'     => ['nullable', 'boolean'],
            'image'      => [$cfg['has_image'] ? 'required' : 'nullable', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $this->compressAndStore($request->file('image'), 'about/' . $type, 600);
        }

        $data['sort_order'] = $data['sort_order'] ?? ((int) AboutItem::ofType($type)->max('sort_order') + 1);
        $data['status']     = $request->boolean('status', true);

        AboutItem::create($data);

        return redirect()->route('admin.about-page.edit')->with('success', 'Added successfully.');
    }

    public function itemUpdate(Request $request, AboutItem $item)
    {
        $data = $request->validate([
            'title'      => ['required', 'string', 'max:255'],
            'text'       => ['nullable', 'string', 'max:1000'],
            'icon'       => ['nullable', 'string', 'max:100'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'status'     => ['required', 'boolean'],
            'image'      => ['nullable', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        if ($request->hasFile('image')) {
            $this->deleteFile($item->image);
            $data['image'] = $this->compressAndStore($request->file('image'), 'about/' . $item->type, 600);
        } else {
            unset($data['image']);
        }

        $data['sort_order'] = $data['sort_order'] ?? 0;

        $item->update($data);

        return redirect()->route('admin.about-page.edit')->with('success', 'Updated successfully.');
    }

    public function itemDestroy(AboutItem $item)
    {
        $this->deleteFile($item->image);
        $item->delete();

        return response()->json(['message' => 'Deleted successfully.']);
    }

    /* ── helpers ── */

    private function deleteFile(?string $path): void
    {
        if (AboutPage::isStored($path) && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    private function compressAndStore(UploadedFile $file, string $folder, int $maxWidth): string
    {
        $image = ImageManager::usingDriver(Driver::class)->decode($file);

        if ($image->width() > $maxWidth) {
            $image->scale(width: $maxWidth);
        }

        $path = trim($folder, '/') . '/' . Str::uuid() . '.webp';

        Storage::disk('public')->put($path, (string) $image->encodeUsingFormat(Format::WEBP, quality: 80));

        return $path;
    }
}