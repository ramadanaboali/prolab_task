<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CountriesTableSeeder::class);
        $this->call(UserRolePermissionSeeder::class);
        $this->call(SchoolSeeder::class);
        $this->call(StudentSeeder::class);
    }
}
