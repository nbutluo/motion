<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('username')->default('')->unique()->comment('用户名');
            $table->string('nickname')->default('')->comment('昵称');
            $table->string('email')->default('')->comment('邮箱');
            $table->string('phone')->default('')->comment('电话号码');
            $table->string('password')->comment('密码');
            $table->string('rule_id')->nullable()->comment('角色id');
            $table->rememberToken();
            $table->string('api_token', 80)->unique()->nullable()->default(null);
            $table->softDeletes();
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
        Schema::dropIfExists('admin_users');
    }
}
