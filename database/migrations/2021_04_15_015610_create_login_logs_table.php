<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateLoginLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('login_logs', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->integer('uid')->default(0)->comment('用户id');
            $table->ipAddress('ip')->default('127.0.0.1')->comment('登录IP地址');
            $table->string('method')->default('')->comment('请求方式');
            $table->string('user_agent')->default('')->comment('UserAgent');
            $table->string('message')->default('')->comment('登录状态信息');
//            $table->timestamp('login_time')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('登陆时间');
//            $table->timestamp('logout_time')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('登出时间');
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
        Schema::dropIfExists('login_logs');
    }
}
