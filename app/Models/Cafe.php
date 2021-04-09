<?php

namespace App\Models;

use App\Notifications\CafeTableFreed;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Notification;

class Cafe extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function tables()
    {
        return $this->hasMany(Table::class);
    }

    public static function takeChunks($start, $numberOfCafes)
    {
        return (new static)::select('id', 'name')->skip($start)->take($numberOfCafes)->get();
    }

    public function subscribedUsers()
    {
        return $this->belongsToMany(User::class);
    }

    public function getTableWithSerialNumber($serialNumber)
    {
        return $this->tables()->where('serial_number', $serialNumber)->firstOrFail();
    }

    public function isFull()
    {
        return $this->tables()->where('empty', false)->count() === $this->tables()->count();
    }

    public function sendTableFreedNotificationToSubscribers()
    {
        Notification::send($this->subscribedUsers, new CafeTableFreed($this));
        $this->subscribedUsers()->detach();
    }

    public function freeTablesCount()
    {
        return $this->tables()->where('empty', true)->count();
    }

}
