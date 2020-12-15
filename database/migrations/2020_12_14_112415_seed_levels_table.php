<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedLevelsTable extends Migration
{

    public function up()
    {
        $levels = [
            [
                'name' => '普通用户',
                'value' => '0',
            ],
            [
                'name' => '一级授权',
                'value' => '1',
            ],
            [
                'name' => '二级授权',
                'value' => '2',
            ],
        ];

        DB::table('levels')->insert($levels);
    }


    public function down()
    {
        DB::table('levels')->truncate();
    }
}
