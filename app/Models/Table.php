<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Table extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function cafe(): BelongsTo
    {
        return $this->belongsTo(Cafe::class);
    }

    public function getEmptyAttribute($value): string
    {
        return $value ? 'Slobodan' : 'Zauzet';
    }

    public function getSmokingAllowedAttribute($value): string
    {
        return $value !== null ? ($value ? 'Dozvoljeno' : 'Zabranjeno') : 'N/A';
    }

    public function toggleAvailability(): Table
    {
        $this->empty = $this->empty == 'Slobodan' ? false : true;
        $this->save();

        return $this;
    }
}
