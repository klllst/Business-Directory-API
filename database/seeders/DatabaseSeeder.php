<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        DB::table('activity_organization')->truncate();
        DB::table('organization_phones')->truncate();
        DB::table('organizations')->truncate();
        DB::table('activities')->truncate();
        DB::table('buildings')->truncate();

        $this->call([
            ActivitySeeder::class,
            BuildingSeeder::class,
            OrganizationSeeder::class,
        ]);
    }
}
