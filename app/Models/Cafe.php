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
        $userTokens = $this->subscribedUsers()->pluck('fcm_token')->toArray();
        if(empty($userTokens)){
            return;
        }
        (new SendNotificationViaFCM())->sendNotifications('fZwsG_3BSambPBdHeX9GNq:APA91bFix8iCOy4d3aV1h7aq7tOOJQsrSkHowHEWd5N7ra0fooAgF3PJsJ78giX1ICzel3ZRA2jnocqKVHk2GXGf5SJ4GglSl5jJK9S7_txS-nxe8Lh81MxkgGEnl8VhR15bLxyh6SgX');
        $this->subscribedUsers()->detach();
    }


}
