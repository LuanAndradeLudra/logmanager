<?php

namespace App\Application\UseCases;

use App\Application\Contracts\OrderRepositoryInterface;
use Illuminate\Support\Collection;

class ListDriverOrders
{
    private OrderRepositoryInterface $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function execute(int $driverId, ?string $startDate = null, ?string $endDate = null): Collection
    {
        return $this->orderRepository
            ->listByDriver($driverId, $startDate, $endDate)
            ->map(fn ($order) => [
                'id' => $order->id,
                'code' => $order->code,
                'delivery_address' => $order->delivery_address,
                'status' => $order->status,
                'created_at' => $order->created_at,
            ]);
    }
}
