<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SeedBulkOrderData extends Migration
{
    public function up()
    {
        $menu = [
            [
                'name' => 'bulk_order.index',
                'guard_name' => 'web',
                'route' => 'admin.bulk_order.index',
                'display_name' => 'Bulk Order列表',
                'is_menu' => 1,
                'parent_id' => 33,
                'type' => 1,
            ],
        ];

        DB::table('permissions')->insert($menu);
    }

    public function down()
    {
        $name = [
            'bulk_order.index',
        ];

        DB::table('permissions')->whereIn('name', $name)->delete();
    }
}
