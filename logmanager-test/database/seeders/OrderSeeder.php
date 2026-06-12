<?php

namespace Database\Seeders;

use App\Infrastructure\Persistence\Eloquent\Models\Driver;
use App\Infrastructure\Persistence\Eloquent\Models\Order;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run()
    {
        $scenarios = [
            'João'   => ['delivered' => 10, 'pending' => 0],
            'Maria'  => ['delivered' => 8,  'pending' => 2],
            'Pedro'  => ['delivered' => 3,  'pending' => 7],
            'Ana'    => ['delivered' => 0,  'pending' => 0],
            'Carlos' => ['delivered' => 2,  'pending' => 2],
        ];

        foreach ($scenarios as $driverName => $counts) {
            $driver = Driver::where('name', $driverName)->firstOrFail();

            if ($counts['delivered'] > 0) {
                Order::factory()
                    ->count($counts['delivered'])
                    ->delivered()
                    ->create(['driver_id' => $driver->id]);
            }

            if ($counts['pending'] > 0) {
                Order::factory()
                    ->count($counts['pending'])
                    ->pending()
                    ->create(['driver_id' => $driver->id]);
            }
        }
    }
}
