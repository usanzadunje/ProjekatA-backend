<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function place(): ?BelongsTo
    {
        return $this->belongsTo(Cafe::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
