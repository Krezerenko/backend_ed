<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'name' => 'Замена моторного масла',
                'description' => 'Полная замена моторного масла и масляного фильтра',
                'price' => 50.00,
                'duration' => 45,
                'category' => 'Техническое обслуживание',
            ],
            [
                'name' => 'Замена воздушного фильтра',
                'description' => 'Замена воздушного фильтра двигателя',
                'price' => 25.00,
                'duration' => 20,
                'category' => 'Техническое обслуживание',
            ],
            [
                'name' => 'Замена тормозной жидкости',
                'description' => 'Полная замена тормозной жидкости с прокачкой',
                'price' => 60.00,
                'duration' => 60,
                'category' => 'Тормозная система',
            ],
            [
                'name' => 'Балансировка колес',
                'description' => 'Балансировка всех четырех колес',
                'price' => 40.00,
                'duration' => 60,
                'category' => 'Ходовая часть',
            ],
            [
                'name' => 'Диагностика подвески',
                'description' => 'Полная диагностика ходовой части',
                'price' => 35.00,
                'duration' => 30,
                'category' => 'Диагностика',
            ],
            [
                'name' => 'Замена аккумулятора',
                'description' => 'Замена автомобильного аккумулятора',
                'price' => 30.00,
                'duration' => 30,
                'category' => 'Электрика',
            ],
            [
                'name' => 'Замена свечей зажигания',
                'description' => 'Замена комплекта свечей зажигания',
                'price' => 45.00,
                'duration' => 40,
                'category' => 'Двигатель',
            ],
        ];

        foreach ($services as $data) {
            Service::firstOrCreate(
                ['name' => $data['name']],
                $data
            );
        }
    }
}