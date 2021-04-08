<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->string('nickname')->comment('');
            $table->tinyInteger('user_leverl')->comment('');
            $table->tinyInteger('sex')->comment('');
            $table->timestamp('birth')->comment('');
            $table->string('email')->comment('');
            $table->string('phone')->comment('');
            $table->string('province')->comment('');
            $table->string('city')->comment('');
            $table->string('area')->comment('');
            $table->string('company_url')->comment('');
            $table->rememberToken();
            $table->string('api_token', 80)->unique()->nullable()->default(null);
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
