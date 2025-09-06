<?php

namespace Database\Seeders;

use App\Models\Activity;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    private $activities = [
        'Автомобили' => [
            'Легковые' => [
                'Запчасти',
                'Аксессуары',
            ],
            'Грузовые' => [
                'Запчасти',
                'Аксессуары',
            ],
        ],
        'Еда' => [
            'Мясная продукция',
            'Молочная продукция',
        ],
        'Одежда' => [
            'Для детей',
            'Для животных',
            'Шубы',
        ],
        'Ресторан' => [
            'Русская кухня',
            'Итальянская кухня',
            'Роллы',
        ],
        'Развлечения' => [
            'Кинотеатр',
            'Компьютерный клуб',
        ],
    ];

    public function run(): void
    {
        foreach ($this->activities as $key => $value) {
            $activity = Activity::create([
                'name' => $key
            ]);

            $this->createSubActivities($activity, $value);
        }
    }

    private function createSubActivities(Activity $parentActivity, array|string $subActivities): void
    {
        foreach ($subActivities as $key => $value) {
            $activity = Activity::create([
                'name' => is_array($value) ? $key : $value,
                'parent_id' => $parentActivity->id,
            ]);

            if (is_array($value)) {
                $this->createSubActivities($activity, $value);
            }
        }
    }
}
