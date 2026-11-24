<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class HomeBlock extends Model
{
    protected $fillable = [
        'section', 'title', 'subtitle', 'image', 'link', 'sort_order', 'status',
    ];

    protected $casts = [
        'status'     => 'boolean',
        'sort_order' => 'integer',
    ];

    // key => label and which extra fields that section uses
    public const SECTIONS = [
        'slider' => [
            'label'    => 'Slider',
            'title'    => 'Heading',
            'subtitle' => 'Text under heading',
            'link'     => false,
            'width'    => 1920,
            'hint'     => 'Large banner image. Heading and text are optional.',
        ],
        'feature' => [
            'label'    => 'Feature Cards',
            'title'    => 'Title',
            'subtitle' => false,
            'link'     => true,
            'width'    => 800,
            'hint'     => 'Cards under the slider, each with a "View All" link. Use a new line in the title to break it.',
        ],
        'top_seller' => [
            'label'    => 'Top Sellers',
            'title'    => 'Title',
            'subtitle' => false,
            'link'     => true,
            'width'    => 800,
            'hint'     => 'Product cards in the "Top Seller Doors" row.',
        ],
    ];

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeSection($query, string $section)
    {
        return $query->where('section', $section);
    }

    // Works for uploads, theme files (assets/...) and full URLs
    public function getImageUrlAttribute(): ?string
    {
        if (blank($this->image)) {
            return null;
        }

        if (Str::startsWith($this->image, ['http://', 'https://'])) {
            return $this->image;
        }

        if (Str::startsWith($this->image, 'assets/')) {
            return asset($this->image);
        }

        return asset('storage/' . ltrim($this->image, '/'));
    }

    // "/category/door", "category/door" or a full URL
    public function getLinkUrlAttribute(): string
    {
        if (blank($this->link)) {
            return 'javascript:void(0);';
        }

        return Str::startsWith($this->link, ['http://', 'https://']) ? $this->link : url($this->link);
    }

    // Only files uploaded from admin live in storage
    public function hasStoredImage(): bool
    {
        return filled($this->image)
            && !Str::startsWith($this->image, ['http://', 'https://', 'assets/']);
    }
}