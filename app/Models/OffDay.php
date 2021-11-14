<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\OffDay
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon $start_date
 * @property int $number_of_days
 * @property string|null $message
 * @property int $status
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|OffDay newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OffDay newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OffDay query()
 * @method static \Illuminate\Database\Eloquent\Builder|OffDay whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OffDay whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OffDay whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OffDay whereNumberOfDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OffDay whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OffDay whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OffDay whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OffDay whereUserId($value)
 * @mixin \Eloquent
 */
class OffDay extends Model
{
    use HasFactory;

    const PENDING = 0;

    const DECLINED = 1;

    const APPROVED = 2;

    protected $guarded = [];

    protected $casts = [
        'start_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
