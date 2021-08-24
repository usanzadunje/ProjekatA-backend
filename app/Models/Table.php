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

    public function scopeAvailable($query, bool $availability)
    {
        return $query->where('empty', $availability);
    }

    public function toggleAvailability()
    {
        if($this->cafe->isFull())
        {
            // Notify all subscribed users that table has been freed in cafe
            $this->cafe->sendTableFreedNotificationToSubscribers();
        }

        $this->update([
            'empty' => !$this->empty,
        ]);
    }
}
