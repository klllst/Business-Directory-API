<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Building;
use App\Models\Organization;
use Illuminate\Database\Seeder;

class OrganizationSeeder extends Seeder
{
    private $organizationTypes = [
        'ООО',
        'ОАО',
        'ЗАО',
    ];

    public function run(): void
    {
        $buildings = Building::all();
        $activities = Activity::pluck('id');

        foreach ($buildings as $building) {
            $count = 5;

            while ($count) {
                $organization = Organization::query()->create([
                    'name' => $this->organizationTypes[array_rand($this->organizationTypes)] . " \"Организация $count\"",
                    'building_id' => $building->id,
                ]);

                $organization->phones()->createMany([
                    ['number' => "+7(908)" . rand(1000000, 9999999)],
                    ['number' => "+7(937)" . rand(1000000, 9999999)],
                ]);

                $organization->activities()->attach($activities->random(2));

                --$count;
            }
        }
    }

}
