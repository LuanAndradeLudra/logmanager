<?php

namespace App\Infrastructure\Persistence\Eloquent\Models;

use App\Domain\Order\OrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Database\Factories\Infrastructure\Persistence\Eloquent\Models\OrderFactory;

class Order extends Model
{
    use HasFactory;

    public const STATUS_PENDING = OrderStatus::PENDING;
    public const STATUS_DELIVERED = OrderStatus::DELIVERED;

    protected $fillable = [
        'driver_id',
        'code',
        'delivery_address',
        'status',
        'delivered_at',
    ];

    protected $casts = [
        'delivered_at' => 'datetime',
    ];

    /**
     * The factory for the model.
     *
     * @return \Database\Factories\Infrastructure\Persistence\Eloquent\Models\OrderFactory
     */
    protected static function newFactory()
    {
        return OrderFactory::new();
    }

    /**
     * The driver for the order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }
}