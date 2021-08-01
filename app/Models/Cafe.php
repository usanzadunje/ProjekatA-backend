<?php

namespace App\Models;

use App\Queries\SortCafes;
use App\Services\SendNotificationViaFCM;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
        return $this->belongsToMany(User::class)->whereNotNull('fcm_token');
    }

    public static function takeChunks($start, $numberOfCafes, $filter = '', $sortBy = 'default', $getAllColumns = false)
    {
        $selectedColumns = $getAllColumns
            ? (new static)::select('id', 'name', 'city', 'address', 'latitude', 'longitude')
            : (new static)::select('id', 'name', 'latitude', 'longitude');

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
        return $this->freeTablesCount() === 0;
    }

    public function freeTablesCount()
    {
        return $this->tables()->where('empty', true)->count();
    }

    public function takenMaxCapacityTableRatio(): string
    {
        // Returning how many tables are taken out of cafe capacity
        // in a form taken/capacity *20/40*
        $cafeCapacity = $this->tables()->count();
        $tablesTaken = $this->tables()->where('empty', 'false')->count();

        return $tablesTaken . '/' . $cafeCapacity;
    }

    public function sendTableFreedNotificationToSubscribers()
    {
        $tokens = $this->subscribedUsers()->pluck('fcm_token')->toArray();
        if(empty($tokens))
        {
            return;
        }
        (new SendNotificationViaFCM())->sendNotifications($tokens);
        $this->subscribedUsers()->detach();
    }

    public function calculateDistance($lat, $lng)
    {
        return DB::select(DB::raw('
            SELECT ST_Distance_Sphere(
                point(?, ?),
                point(?, ?)
            ) distance
        '), [$lng ?? 0, $lat ?? 0, $this->longitude, $this->latitude]);
    }
}
