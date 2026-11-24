<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['category_id', 'name', 'image', 'sort_order', 'status'];

    protected $casts = ['status' => 'boolean'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Works for seeded paths (assets/...) and uploaded files (storage disk)
    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) {
            return null;
        }

        return str_starts_with($this->image, 'assets/')
            ? asset($this->image)
            : asset('storage/' . $this->image);
    }
}