<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    
    


    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user(): BelongsTo
    {
    return $this->belongsTo(User::class);
    }

    public function payments(): HasOne{
        return $this->hasOne(Payment::class);
    }


}
