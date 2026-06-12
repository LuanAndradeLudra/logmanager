<?php

namespace App\Infrastructure\Persistence\Eloquent\Repositories;

use App\Application\Contracts\DriverRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\Models\Driver;
use App\Infrastructure\Persistence\Eloquent\Models\Order;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class EloquentDriverRepository implements DriverRepositoryInterface
{
    public function listWithStats(?string $startDate = null, ?string $endDate = null): Collection
    {
        return Driver::query()
            ->withCount([
                'orders as orders_count' => function (Builder $query) use ($startDate, $endDate) {
                    $this->applyDateFilter($query, $startDate, $endDate);
                },
                'orders as delivered_orders_count' => function (Builder $query) use ($startDate, $endDate) {
                    $this->applyDateFilter($query, $startDate, $endDate);
                    $query->where('status', Order::STATUS_DELIVERED);
                },
            ])
            ->orderBy('name')
            ->get();
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
