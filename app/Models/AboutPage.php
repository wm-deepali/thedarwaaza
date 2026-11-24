<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AboutPage extends Model
{
    protected $fillable = [
        'banner_title', 'about_heading', 'about_content', 'about_image',
        'why_heading', 'why_text',
        'brochure_heading', 'brochure_text', 'brochure_image', 'brochure_link',
        'process_heading',
    ];

    /** Always one row (id = 1). */
    public static function getInstance(): self
    {
        return static::firstOrCreate(['id' => 1]);
    }

    /** Uploads, theme files (assets/...) and full URLs. */
    public static function resolveImage(?string $path): ?string
    {
        if (blank($path)) {
            return null;
        }

        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        return Str::startsWith($path, 'assets/')
            ? asset($path)
            : asset('storage/' . ltrim($path, '/'));
    }

    /** Only files uploaded from admin live in storage. */
    public static function isStored(?string $path): bool
    {
        return filled($path) && !Str::startsWith($path, ['http://', 'https://', 'assets/']);
    }

    public function getAboutImageUrlAttribute(): ?string
    {
        return self::resolveImage($this->about_image);
    }

    public function getBrochureImageUrlAttribute(): ?string
    {
        return self::resolveImage($this->brochure_image);
    }

    public function getBrochureLinkUrlAttribute(): string
    {
        $link = $this->brochure_link ?: 'pdf/thedarwaaza.pdf';

        return Str::startsWith($link, ['http://', 'https://']) ? $link : asset($link);
    }

    /** One paragraph per line. */
    public function getParagraphsAttribute(): array
    {
        return array_values(array_filter(
            array_map('trim', preg_split('/\r\n|\r|\n/', (string) $this->about_content))
        ));
    }
}