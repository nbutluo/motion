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
            $table->string('username')->unique()->comment('用户名');
            $table->string('password')->comment('密码');
            $table->string('nickname')->default('')->comment('');
            $table->tinyInteger('user_leverl')->default(0)->comment('用户等级：0普通用户，1一级用户，2二级用户');
            $table->tinyInteger('sex')->default(0)->comment('性别：0女，1男');
            $table->string('birth')->default('')->comment('生日');
            $table->string('email')->default('')->comment('email');
            $table->string('phone')->default('')->comment('');
            $table->string('province')->default('')->comment('');
            $table->string('city')->default('')->comment('');
            $table->string('area')->default('')->comment('');
            $table->string('company_url')->default('')->comment('');
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
