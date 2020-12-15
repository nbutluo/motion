<?php

use Illuminate\Database\Seeder;
use App\Models\Apply;

class AppliesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Apply::class)->times(100)->create();
    }
}
