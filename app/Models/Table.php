<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function cafe()
    {
        return $this->belongsTo(Cafe::class);
    }

    public function getEmptyAttribute($value)
    {
        return $value ? 'Slobodan' : 'Zauzet';
    }

    public function getSmokingAllowedAttribute($value)
    {
        return $value !== null ? ($value ? 'Dozvoljeno' : 'Zabranjeno') : 'N/A';
    }

    public function toggleAvailability()
    {
        $this->empty = $this->empty == 'Slobodan' ? false : true;
        $this->save();
        return $this;
    }
}
