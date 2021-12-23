<?php

use App\Model\HomepageBanner;
use Illuminate\Database\Seeder;

class HomepageBannerSeeder extends Seeder
{
    public function run()
    {
        factory(HomepageBanner::class, 10)->create();
    }
}
