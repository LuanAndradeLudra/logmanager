<?php

namespace App\Application\UseCases;

use App\Application\Contracts\OrderRepositoryInterface;
use App\Application\DTOs\UpdateOrderData;
use App\Domain\Order\OrderStatus;
use App\Infrastructure\Persistence\Eloquent\Models\Order;

class UpdateOrder
{
    private OrderRepositoryInterface $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function execute(int $orderId, UpdateOrderData $input): Order
    {
        $order = $this->orderRepository->findById($orderId);
        $data = new UpdateOrderData();

        if ($input->updateDeliveryAddress) {
            $data->deliveryAddress = $input->deliveryAddress;
            $data->updateDeliveryAddress = true;
        }

        if ($input->updateStatus) {
            $data->status = $input->status;
            $data->deliveredAt = OrderStatus::resolveDeliveredAt(
                $input->status,
                $order->delivered_at
            );
            $data->updateStatus = true;
        }

        return $this->orderRepository->update($order, $data);
    }
}
