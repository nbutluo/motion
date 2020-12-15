<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned()->index();
            $table->enum('previous_level', [0, 1, 2])->nullable()->comment('之前权限');
            $table->enum('apply_level', [0, 1, 2])->nullable(false)->comment('申请权限等级');
            $table->text('apply_reason')->nullable()->comment('申请理由');
            $table->enum('is_audit', [0, 1, 2])->default(0)->comment('审核状态');
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
        Schema::dropIfExists('applies');
    }
}
