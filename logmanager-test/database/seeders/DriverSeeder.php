<?php

namespace Database\Seeders;

use App\Infrastructure\Persistence\Eloquent\Models\Driver;
use Illuminate\Database\Seeder;

class DriverSeeder extends Seeder
{
    public function run()
    {
        $drivers = [
            'João',
            'Maria',
            'Pedro',
            'Ana',
            'Carlos',
        ];

        foreach ($drivers as $name) {
            Driver::factory()->create(['name' => $name]);
        }
    }
}
