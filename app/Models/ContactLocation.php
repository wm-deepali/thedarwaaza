<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactLocation extends Model
{
    protected $fillable = ['title', 'address', 'sort_order', 'status'];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', true)->orderBy('sort_order')->orderBy('id');
    }
}