<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable=['name', 'description', 'price', 'stock', 'category_id', 'size', 'image_id'];

 public function category(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function image(): HasMany
    {
        return $this->hasMany(Image::class);
    }

    public function orderItem(): BelongsTo
    {
    return $this->belongsTo(OrderItem::class);
    }

}
