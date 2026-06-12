<?php

namespace Tests\Unit\Domain\Driver;

use App\Domain\Driver\DriverPerformance;
use PHPUnit\Framework\TestCase;

class DriverPerformanceTest extends TestCase
{
    /** @dataProvider classificationProvider */
    public function test_it_classifies_driver_performance(int $orders, int $delivered, string $expected): void
    {
        $this->assertSame($expected, DriverPerformance::classify($orders, $delivered));
    }

    public function classificationProvider(): array
    {
        return [
            'completed - all delivered' => [10, 10, DriverPerformance::COMPLETED],
            'almost done - above 50%' => [10, 8, DriverPerformance::ALMOST_DONE],
            'almost done - 6 of 10' => [10, 6, DriverPerformance::ALMOST_DONE],
            'alert - below 50%' => [10, 3, DriverPerformance::ALERT],
            'alert - exactly 50%' => [10, 5, DriverPerformance::ALERT],
            'alert - carlos scenario' => [4, 2, DriverPerformance::ALERT],
            'none - no orders' => [0, 0, DriverPerformance::NONE],
        ];
    }
}
