<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SeedNewArrivalData extends Migration
{
    public function up()
    {
        $menu = [
            'name' => 'catalog.new_arrival',
            'guard_name' => 'web',
            'route' => 'admin.new_arrival.index',
            'display_name' => 'New Arrival 新品',
            'is_menu' => 1,
            'parent_id' => 55
        ];

        DB::table('permissions')->insert($menu);
    }

    public function down()
    {
        $name = 'catalog.new_arrival';

        DB::table('permissions')->where('name', $name)->delete();
    }
}
