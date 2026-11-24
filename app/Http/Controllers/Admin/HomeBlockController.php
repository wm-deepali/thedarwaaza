<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeBlock;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Format;
use Intervention\Image\ImageManager;

class HomeBlockController extends Controller
{
    public function index(Request $request)
    {
        $sections = HomeBlock::SECTIONS;
        $section  = array_key_exists($request->query('section'), $sections) ? $request->query('section') : 'slider';
        $cfg      = $sections[$section];

        $blocks = HomeBlock::section($section)->orderBy('sort_order')->orderBy('id')->get();

        $counts = HomeBlock::selectRaw('section, COUNT(*) as total')->groupBy('section')->pluck('total', 'section');

        return view('admin.home-blocks.index', compact('sections', 'section', 'cfg', 'blocks', 'counts'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'section'    => ['required', 'in:' . implode(',', array_keys(HomeBlock::SECTIONS))],
            'title'      => ['nullable', 'string', 'max:255'],
            'subtitle'   => ['nullable', 'string', 'max:255'],
            'link'       => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'status'     => ['nullable', 'boolean'],
            'image'      => ['required', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        $width = HomeBlock::SECTIONS[$data['section']]['width'];

        $data['image']      = $this->compressAndStore($request->file('image'), 'home/' . $data['section'], $width);
        $data['sort_order'] = $data['sort_order'] ?? ((int) HomeBlock::section($data['section'])->max('sort_order') + 1);
        $data['status']     = $request->boolean('status', true);

        HomeBlock::create($data);

        return redirect()->route('admin.home-blocks.index', ['section' => $data['section']])
            ->with('success', 'Added successfully.');
    }

    public function update(Request $request, HomeBlock $homeBlock)
    {
        $data = $request->validate([
            'title'      => ['nullable', 'string', 'max:255'],
            'subtitle'   => ['nullable', 'string', 'max:255'],
            'link'       => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'status'     => ['required', 'boolean'],
            'image'      => ['nullable', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        if ($request->hasFile('image')) {
            $this->deleteImage($homeBlock);
            $width         = HomeBlock::SECTIONS[$homeBlock->section]['width'];
            $data['image'] = $this->compressAndStore($request->file('image'), 'home/' . $homeBlock->section, $width);
        } else {
            unset($data['image']);
        }

        $data['sort_order'] = $data['sort_order'] ?? 0;

        $homeBlock->update($data);

        return redirect()->route('admin.home-blocks.index', ['section' => $homeBlock->section])
            ->with('success', 'Updated successfully.');
    }

    public function destroy(HomeBlock $homeBlock)
    {
        $this->deleteImage($homeBlock);
        $homeBlock->delete();

        return response()->json(['message' => 'Deleted successfully.']);
    }

    /* ── helpers ── */

    private function deleteImage(HomeBlock $block): void
    {
        if ($block->hasStoredImage() && Storage::disk('public')->exists($block->image)) {
            Storage::disk('public')->delete($block->image);
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