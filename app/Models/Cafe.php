<?php

namespace App\Models;

use App\Queries\SortCafes;
use App\Services\SendNotificationViaFCM;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Cafe extends Model
{
    use HasFactory, SortCafes;

    protected $guarded = [];

    public function tables(): HasMany
    {
        return $this->hasMany(Table::class);
    }

    public function offerings(): BelongsToMany
    {
        return $this->belongsToMany(Offering::class);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function subscribedUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->whereNotNull('fcm_token');
    }

    public function getTableWithSerialNumber($serialNumber): HasMany
    {
        return $this->tables()->where('serial_number', $serialNumber)->firstOrFail();
    }

    public function freeTablesCount(): int
    {
        return $this->tables()->available(true)->count();
    }

    public function isFull(): bool
    {
        return $this->freeTablesCount() === 0;
    }

    public function takenMaxCapacityTableRatio(): string
    {
        // Returning how many tables are taken out of cafe capacity
        // in a form taken/capacity *20/40*
        $cafeCapacity = $this->tables()->count();
        $tablesTaken = $this->tables()->available(false)->count();

        return $tablesTaken . '/' . $cafeCapacity;
    }

    public function sendTableFreedNotificationToSubscribers()
    {
        $tokens = $this->subscribedUsers()->pluck('fcm_token')->toArray();
        if(!empty($tokens))
        {
            (new SendNotificationViaFCM())->sendNotifications($tokens);
            $this->subscribedUsers()->detach();
        }
    }

    public function calculateDistance($lat, $lng): array
    {
        return DB::select(DB::raw('
            SELECT ST_Distance_Sphere(
                point(?, ?),
                point(?, ?)
            ) distance
        '), [$lng ?? 0, $lat ?? 0, $this->longitude, $this->latitude]);
    }
}
