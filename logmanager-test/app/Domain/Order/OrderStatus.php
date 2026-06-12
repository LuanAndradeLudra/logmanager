<?php

namespace App\Domain\Order;

use InvalidArgumentException;

final class OrderStatus
{
    public const PENDING = 'pending';
    public const DELIVERED = 'delivered';

    public static function resolveDeliveredAt(string $newStatus, ?\DateTimeInterface $currentDeliveredAt): ?\DateTimeInterface
    {
        if (! in_array($newStatus, [self::PENDING, self::DELIVERED], true)) {
            throw new InvalidArgumentException("Invalid order status: {$newStatus}");
        }

        if ($newStatus === self::DELIVERED) {
            return $currentDeliveredAt ?? now();
        }

        return null;
    }
}
