<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function PHPSTORM_META\type;

class SeedHomepageBannerData extends Migration
{
    public function up()
    {
        $menu = [
            [
                'name' => 'catalog.homepage_banner',
                'guard_name' => 'web',
                'route' => 'admin.homepage_banner',
                'display_name' => '首页Banner',
                'is_menu' => 1,
                'parent_id' => 74,
                'type' => 1,
            ],
        ];

        DB::table('permissions')->insert($menu);
    }

    public function down()
    {
        $name = [
            'catalog.homepage_banner',
        ];

        DB::table('permissions')->whereIn('name', $name)->delete();
    }
}
