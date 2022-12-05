<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Collection\Collection;

/**
 * Class Order
 *
 * @property int $id
 * @property int $user_id
 * @property int $handled_by
 * @property string $reference_code
 * @property string|null $notes
 * @property string $delivery_address
 * @property double $total_amount
 * @property string $status
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|OrderDetail[] $details
 * @property User $user
 * @property User $handler
 *
 * @package App\Models
 */
class Order extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'reference_code',
        'user_id',
        'handled_by',
        'notes',
        'delivery_address',
        'total_amount',
        'status'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'user_id' => 'int',
        'handled_by' => 'int'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function details()
    {
        return $this->hasMany(OrderDetail::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function handler()
    {
        return $this->belongsTo(User::class, 'handled_by');
    }
}
