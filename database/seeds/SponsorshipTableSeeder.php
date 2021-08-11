<?php

use Illuminate\Database\Seeder;

class SponsorshipTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(App\Sponsorship::class, 10)->create();
    }
}
