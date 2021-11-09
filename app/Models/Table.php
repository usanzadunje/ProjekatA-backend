<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Table
 *
 * @property int $id
 * @property int $empty
 * @property int|null $smoking_allowed
 * @property int $top
 * @property float $left
 * @property int $place_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Place $place
 * @method static \Illuminate\Database\Eloquent\Builder|Table available(bool $availability)
 * @method static \Database\Factories\TableFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Table newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Table newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Table query()
 * @method static \Illuminate\Database\Eloquent\Builder|Table wherePlaceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Table whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Table whereEmpty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Table whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Table whereLeft($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Table whereSmokingAllowed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Table whereTop($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Table whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Table extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function place(): BelongsTo
    {
        return $this->belongsTo(Place::class);
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function scopeAvailable($query, bool $availability)
    {
        return $query->where('empty', $availability);
    }

    public function toggleAvailability()
    {
        $this->update([
            'empty' => !$this->empty,
        ]);
    }
}
