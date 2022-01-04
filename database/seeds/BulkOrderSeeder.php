<?php

use App\Model\BulkOrder;
use Illuminate\Database\Seeder;

class BulkOrderSeeder extends Seeder
{
    public function run()
    {
        factory(BulkOrder::class, 50)->create();
    }
}
