<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderItem extends Model
{
     protected $fillable = ['order_id', 'product_id', 'price'];


      public function product(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function order()
{
    return $this->belongsTo(Order::class);
}
}
