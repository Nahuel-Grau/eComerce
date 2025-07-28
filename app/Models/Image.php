<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Image extends Model
{
    protected $table = ['images'];
    protected $fillable = ['image'];

    
    public function product(): BelongsToMany
    {
    return $this->BelongsToMany(Product::class);
    }
}
