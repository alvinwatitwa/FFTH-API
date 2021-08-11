<?php

use Illuminate\Database\Seeder;

class CrisisTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(App\Crisis::class, 10)->create();
    }
}
