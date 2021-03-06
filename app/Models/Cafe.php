<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cafe extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function tables()
    {
        return $this->hasMany(Table::class);
    }

    public function subscribedUsers()
    {
        return $this->belongsToMany(User::class);
    }

    public function getTableWithSerialNumber($serialNumber)
    {
        return $this->tables()->where('serial_number', $serialNumber)->firstOrFail();
    }

}
