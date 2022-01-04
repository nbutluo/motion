<?php

use App\Model\BulkOrder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            AdminUsersTableSeeder::class,
            ConfigurationTableSeeder::class,
            MenuCategoryTableSeeder::class,
            FooterLinksTableSeeder::class,
            HomepageBannerSeeder::class,
            BulkOrderSeeder::class,
        ]);
    }
}
