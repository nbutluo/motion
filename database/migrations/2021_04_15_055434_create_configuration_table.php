<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateConfigurationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configuration', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->integer('group_id')->default(0)->comment('所属组');
            $table->string('label')->default('')->comment('配置项名称');
            $table->string('key')->default('')->comment('配置项键值');
            $table->string('val')->default('')->comment('配置项值');
            $table->string('type')->default('input')->comment('配置项类型，input输入框，radio单选，select下拉,image单图片');
            $table->text('content')->nullable()->comment('配置项类型的内容');
            $table->string('tips')->nullable()->comment('输入提示');
            $table->tinyInteger('sort')->default(10)->comment('排序');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE `configuration` comment '配置项表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('configuration');
    }
}
