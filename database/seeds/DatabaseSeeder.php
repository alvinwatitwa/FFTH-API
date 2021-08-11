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
        $this->call(ChildrenTableSeeder::class);
        $this->call(SponsorshipTableSeeder::class);
        $this->call(CrisisTableSeeder::class);
    }
}
