<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'user_id', 'name', 'slug', 'description',
        'price', 'condition', 'size', 'brand', 'stock', 'images', 'is_active', 'views'
    ];

    protected $casts = [
        'images' => 'array',
        'is_active' => 'boolean',
        'price' => 'decimal:2',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    public function getMainImageAttribute(): ?string
    {
        $images = $this->images;
        return $images ? ($images[0] ?? null) : null;
    }

    public function getConditionLabelAttribute(): string
    {
        return match($this->condition) {
            'brand_new' => 'Baru',
            'like_new'  => 'Seperti Baru',
            'good'      => 'Baik',
            'fair'      => 'Cukup',
            default     => 'Baik',
        };
    }
}
