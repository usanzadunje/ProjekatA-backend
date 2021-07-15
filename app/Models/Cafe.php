<?php

namespace App\Models;

use App\Queries\SortCafes;
use App\Services\SendNotificationViaFCM;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cafe extends Model
{
    use HasFactory, SortCafes;

    protected $guarded = [];

    public function tables()
    {
        return $this->hasMany(Table::class);
    }

    public function offerings()
    {
        return $this->belongsToMany(Offering::class);
    }

    public function subscribedUsers()
    {
        return $this->belongsToMany(User::class);
    }

    public static function takeChunks($start, $numberOfCafes, $filter = '', $sortBy = 'name', $getAllColumns = false)
    {
        $selectedColumns = $getAllColumns
            ? (new static)::select('id', 'name', 'city', 'address', 'email', 'phone')
            : (new static)::select('id', 'name');

        return $selectedColumns->sortedCafes($sortBy, $filter)
            ->skip($start)
            ->take($numberOfCafes)
            ->get();
    }

    public function getTableWithSerialNumber($serialNumber)
    {
        return $this->tables()->where('serial_number', $serialNumber)->firstOrFail();
    }

    public function isFull()
    {
        return $this->tables()->where('empty', false)->count() === $this->tables()->count();
    }

    public function freeTablesCount()
    {
        return $this->tables()->where('empty', true)->count();
    }

    public function takenMaxCapacityTableRatio()
    {
        // Returning how many tables are taken out of cafe capacity
        // in a form taken/capacity *20/40*
        $cafeCapacity = $this->tables()->count();
        $tablesTaken = $this->tables()->where('empty', 'false')->count();

        return $tablesTaken . '/' . $cafeCapacity;
    }

    public function sendTableFreedNotificationToSubscribers()
    {
        (new SendNotificationViaFCM())->sendNotifications($this->subscribedUsers()->pluck('fcm_token'));
        $this->subscribedUsers()->detach();
    }


}
