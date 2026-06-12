<?php

namespace App\Application\UseCases;

use App\Domain\Order\OrderStatus;
use App\Application\Contracts\OrderRepositoryInterface;
use Illuminate\Support\Collection;

class ListDriverDeliveries
{
    private OrderRepositoryInterface $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function execute(int $driverId, ?string $startDate = null, ?string $endDate = null): Collection
    {
        return $this->orderRepository
            ->listByDriver($driverId, $startDate, $endDate, OrderStatus::DELIVERED)
            ->map(fn ($order) => [
                'id' => $order->id,
                'code' => $order->code,
                'delivery_address' => $order->delivery_address,
                'delivered_at' => $order->delivered_at,
            ]);
    }
}
