<?php

namespace App\Models;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'parent_id',
        'name',
        'slug',
        'image',
        'banner_image',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'canonical_url',
        'sort_order',
        'show_in_navbar',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'show_in_navbar' => 'boolean',
    ];

    protected static function booted(): void
    {
        $flush = fn() => Cache::forget('nav_categories');

        static::saved($flush);
        static::deleted($flush);
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // All children (admin)
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id')
            ->orderBy('sort_order')
            ->orderBy('name');
    }

    // Only active children (frontend)
    public function activeChildren()
    {
        return $this->children()->where('status', 1);
    }

    // Only children that should appear in the navbar
    public function navChildren()
    {
        return $this->hasMany(Category::class, 'parent_id')
            ->where('status', 1)
            ->where('show_in_navbar', 1)
            ->orderBy('sort_order')
            ->orderBy('name');
    }

    public function products()
    {
        return $this->hasMany(Product::class)
            ->orderBy('sort_order')
            ->orderBy('id');
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->resolveUrl($this->image);
    }

    public function getBannerUrlAttribute(): ?string
    {
        return $this->resolveUrl($this->banner_image);
    }

    // "Door › Membrane Door" – used in the parent dropdown
    public function getFullPathAttribute(): string
    {
        return $this->parent
            ? $this->parent->full_path . ' › ' . $this->name
            : $this->name;
    }

    // Root → parent, for breadcrumbs: [Door, Membrane Door]
    public function ancestors(): array
    {
        $list = [];
        $node = $this->parent;

        while ($node) {
            array_unshift($list, $node);
            $node = $node->parent;
        }

        return $list;
    }

    // Used to stop a category being moved under itself / its own child
    public function descendantIds(): array
    {
        $ids = [];

        foreach ($this->children as $child) {
            $ids[] = $child->id;
            $ids = array_merge($ids, $child->descendantIds());
        }

        return $ids;
    }

    private function resolveUrl(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        return str_starts_with($path, 'assets/')
            ? asset($path)
            : asset('storage/' . $path);
    }
}