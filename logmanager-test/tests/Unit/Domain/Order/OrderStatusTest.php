<?php

namespace Tests\Unit\Domain\Order;

use App\Domain\Order\OrderStatus;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class OrderStatusTest extends TestCase
{
    public function test_it_sets_delivered_at_when_marking_as_delivered(): void
    {
        $deliveredAt = OrderStatus::resolveDeliveredAt(OrderStatus::DELIVERED, null);

        $this->assertNotNull($deliveredAt);
    }

    public function test_it_keeps_existing_delivered_at_when_already_delivered(): void
    {
        $existing = new \DateTimeImmutable('2025-01-15 10:00:00');

        $deliveredAt = OrderStatus::resolveDeliveredAt(OrderStatus::DELIVERED, $existing);

        $this->assertSame($existing, $deliveredAt);
    }

    public function test_it_clears_delivered_at_when_marking_as_pending(): void
    {
        $deliveredAt = OrderStatus::resolveDeliveredAt(
            OrderStatus::PENDING,
            new \DateTimeImmutable('2025-01-15 10:00:00')
        );

        $this->assertNull($deliveredAt);
    }

    public function test_it_rejects_invalid_status(): void
    {
        $this->expectException(InvalidArgumentException::class);

        OrderStatus::resolveDeliveredAt('invalid', null);
    }
}
