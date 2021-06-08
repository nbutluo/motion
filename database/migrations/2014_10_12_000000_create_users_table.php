<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('username')->unique()->comment('username');
            $table->string('password')->comment('password');
            $table->string('nickname')->default('')->comment('');
            $table->tinyInteger('user_level')->default(0)->comment('用户等级：0普通用户，1一级用户，2二级用户');
            $table->string('avatar')->default('')->comment('user avatar');
            $table->tinyInteger('sex')->default(0)->comment('sex：0woman，1man');
            $table->string('birth')->default('')->comment('birth');
            $table->string('email')->default('')->comment('email');
            $table->integer('salesman')->default(0)->comment('Salesman');
            $table->string('phone')->default('')->comment('phone');
            $table->string('country')->default('')->comment('country');
            $table->string('province')->default('')->comment('province');
            $table->string('city')->default('')->comment('city');
            $table->string('area')->default('')->comment('area');
            $table->string('company_url')->default('')->comment('company_url');
            $table->rememberToken();
            $table->string('api_token', 80)->unique();
            $table->softDeletes();
            $table->timestamp('last_login')->comment('上次登录时间')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
