<?php

namespace App\Application\Contracts;

use App\Application\DTOs\UpdateOrderData;
use App\Infrastructure\Persistence\Eloquent\Models\Order;
use Illuminate\Support\Collection;

interface OrderRepositoryInterface
{
    public function findById(int $id): Order;

    public function listByDriver(
        int $driverId,
        ?string $startDate = null,
        ?string $endDate = null,
        ?string $status = null
    ): Collection;

    public function update(Order $order, UpdateOrderData $data): Order;
}
