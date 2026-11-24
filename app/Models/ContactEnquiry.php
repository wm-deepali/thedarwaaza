<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactEnquiry extends Model
{
    protected $fillable = [
        'product_id',
        'name',
        'email',
        'phone',
        'type',
        'message',
        'ip_address',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}