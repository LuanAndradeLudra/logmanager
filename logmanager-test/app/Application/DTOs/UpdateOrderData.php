<?php

namespace App\Application\DTOs;

final class UpdateOrderData
{
    public ?string $deliveryAddress = null;
    public ?string $status = null;
    public ?\DateTimeInterface $deliveredAt = null;

    public bool $updateDeliveryAddress = false;
    public bool $updateStatus = false;

    public static function fromArray(array $data): self
    {
        $dto = new self();

        if (array_key_exists('delivery_address', $data)) {
            $dto->deliveryAddress = $data['delivery_address'];
            $dto->updateDeliveryAddress = true;
        }

        if (array_key_exists('status', $data)) {
            $dto->status = $data['status'];
            $dto->updateStatus = true;
        }

        return $dto;
    }
}
