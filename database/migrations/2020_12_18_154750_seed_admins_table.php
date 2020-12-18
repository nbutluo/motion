<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $admins = [
            [
                'name' => 'admin',
                'password' => 'admin'
            ],
            [
                'name' => 'loctek',
                'password' => 'loctek'
            ],
        ];
        DB::table('admins')->insert($admins);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('admins')->truncate();
    }
}
