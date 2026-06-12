<?php

namespace App\Infrastructure\Persistence\Eloquent\Repositories;

use App\Application\Contracts\OrderRepositoryInterface;
use App\Application\DTOs\UpdateOrderData;
use App\Infrastructure\Persistence\Eloquent\Models\Order;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class EloquentOrderRepository implements OrderRepositoryInterface
{
    public function findById(int $id): Order
    {
        return Order::query()->findOrFail($id);
    }

    public function listByDriver(
        int $driverId,
        ?string $startDate = null,
        ?string $endDate = null,
        ?string $status = null
    ): Collection {
        $query = Order::query()
            ->where('driver_id', $driverId)
            ->when($status, fn (Builder $q) => $q->where('status', $status))
            ->tap(fn (Builder $q) => $this->applyDateFilter($q, $startDate, $endDate));

        if ($status === Order::STATUS_DELIVERED) {
            $query->orderByDesc('delivered_at');
        } else {
            $query->orderByDesc('created_at');
        }

        return $query->get();
    }

    public function update(Order $order, UpdateOrderData $data): Order
    {
        if ($data->updateDeliveryAddress) {
            $order->delivery_address = $data->deliveryAddress;
        }

        if ($data->updateStatus) {
            $order->status = $data->status;
            $order->delivered_at = $data->deliveredAt;
        }

        $order->save();

        return $order->fresh();
    }

    private function applyDateFilter(Builder $query, ?string $startDate, ?string $endDate): void
    {
        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }
    }
}
