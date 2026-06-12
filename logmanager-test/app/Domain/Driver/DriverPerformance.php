<?php

namespace App\Domain\Driver;

final class DriverPerformance
{
    public const COMPLETED = 'completed';
    public const ALMOST_DONE = 'almost_done';
    public const ALERT = 'alert';
    public const NONE = 'none';

    public static function classify(int $totalOrders, int $totalDelivered): string
    {
        if ($totalOrders === 0) {
            return self::NONE;
        }

        if ($totalDelivered === $totalOrders) {
            return self::COMPLETED;
        }

        if ($totalDelivered > ($totalOrders * 0.5)) {
            return self::ALMOST_DONE;
        }

        return self::ALERT;
    }
}
