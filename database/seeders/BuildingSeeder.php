<?php

namespace Database\Seeders;

use App\Models\Building;
use Illuminate\Database\Seeder;

class BuildingSeeder extends Seeder
{
    private $cities = [
        'Москва',
        'Санкт-Петербург',
        'Казань',
    ];

    private $streets = [
        'Ленина',
        'Мира',
        'Гончарова',
        'Центральная',
        'Минская',
    ];

    public function run()
    {
        foreach ($this->cities as $city) {
            foreach ($this->streets as $street) {
                $count = 5;

                while ($count) {
                    Building::create([
                        'address' => [
                            'city' => $city,
                            'street' => $street,
                            'house' => rand(0, 100),
                        ],
                        'latitude' => rand(520000,600000)/10000,
                        'longitude' => rand(200000,600000)/10000,
                    ]);

                    --$count;
                }
            }
        }

    }
}
