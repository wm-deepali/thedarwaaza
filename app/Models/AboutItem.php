<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutItem extends Model
{
    protected $fillable = ['type', 'title', 'text', 'image', 'icon', 'sort_order', 'status'];

    protected $casts = [
        'status'     => 'boolean',
        'sort_order' => 'integer',
    ];

    public const TYPES = [
        'why' => [
            'label'     => 'Why Choose Us cards',
            'has_image' => true,
            'has_text'  => false,
            'has_icon'  => false,
        ],
        'process' => [
            'label'     => 'Working process steps',
            'has_image' => false,
            'has_text'  => true,
            'has_icon'  => true,
        ],
    ];

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }

    public function getImageUrlAttribute(): ?string
    {
        return AboutPage::resolveImage($this->image);
    }
}