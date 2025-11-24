<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrderStatFactory extends Factory
{
    public function definition(): array
    {
        $categories = ['Техническое обслуживание', 'Тормозная система', 'Ходовая часть', 'Диагностика', 'Электрика', 'Двигатель'];

        return [
            'customer_name' => $this->faker->name(),
            'service_category' => $this->faker->randomElement($categories),
            'order_date' => $this->faker->dateTimeBetween('-3 months', 'now')->format('Y-m-d'),
            'revenue' => $this->faker->randomFloat(2, 20, 200),
            'status' => $this->faker->randomElement(['completed', 'canceled', 'refunded']),
        ];
    }
}