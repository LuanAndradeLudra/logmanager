<?php

namespace Database\Factories\Infrastructure\Persistence\Eloquent\Models;

use App\Infrastructure\Persistence\Eloquent\Models\Driver;
use App\Infrastructure\Persistence\Eloquent\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'driver_id' => Driver::factory(),
            'code' => 'PED-' . str_pad(
                $this->faker->unique()->numberBetween(1, 99999),
                5,
                '0',
                STR_PAD_LEFT
            ),
            'delivery_address' => $this->faker->streetAddress() . ', ' .
                $this->faker->city() . ' - ' .
                $this->faker->stateAbbr(),
            'status' => Order::STATUS_PENDING,
            'delivered_at' => null,
            'created_at' => $this->faker->dateTimeBetween('-30 days', 'now'),
            'updated_at' => now(),
        ];
    }

    /**
     * Indicate that the order is delivered.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function delivered()
    {
        return $this->state(function (array $attributes) {
            $createdAt = $attributes['created_at'] ?? now();

            return [
                'status' => Order::STATUS_DELIVERED,
                'delivered_at' => $this->faker->dateTimeBetween($createdAt, 'now'),
            ];
        });
    }

    /**
     * Indicate that the order is pending.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function pending()
    {
        return $this->state(function () {
            return [
                'status' => Order::STATUS_PENDING,
                'delivered_at' => null,
            ];
        });
    }
}
