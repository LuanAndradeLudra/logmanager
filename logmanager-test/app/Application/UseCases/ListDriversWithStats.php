<?php

namespace App\Application\UseCases;

use App\Application\Contracts\DriverRepositoryInterface;
use App\Domain\Driver\DriverPerformance;
use Illuminate\Support\Collection;

class ListDriversWithStats
{
    private DriverRepositoryInterface $driverRepository;

    public function __construct(DriverRepositoryInterface $driverRepository)
    {
        $this->driverRepository = $driverRepository;
    }

    public function execute(?string $startDate = null, ?string $endDate = null, ?string $status = null): Collection
    {
        return $this->driverRepository
            ->listWithStats($startDate, $endDate)
            ->map(function ($driver) {
                return [
                    'id' => $driver->id,
                    'name' => $driver->name,
                    'orders_count' => $driver->orders_count,
                    'delivered_orders_count' => $driver->delivered_orders_count,
                    'performance' => DriverPerformance::classify(
                        $driver->orders_count,
                        $driver->delivered_orders_count
                    ),
                ];
            })
            ->when($status && $status !== 'all', function (Collection $drivers) use ($status) {
                return $drivers->filter(fn (array $driver) => $driver['performance'] === $status);
            })
            ->values();
    }
}
