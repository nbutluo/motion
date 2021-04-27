<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('name')->nullable()->comment('Company Name');
            $table->string('email')->default('0')->comment('Email');
            $table->integer('customer_id')->default(0)->comment('Customer Id');
            $table->string('phone')->nullable()->comment('Phone Number');
            $table->string('continent')->nullable()->comment('Continent');
            $table->string('country')->nullable()->comment('Country');
            $table->string('city')->nullable()->comment('City');
            $table->string('identity')->nullable()->comment('Identity');
            $table->smallInteger('remark_option',6)->nullable()->comment('咨询选项');
            $table->text('remark')->nullable()->comment('留言内容');
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
        Schema::dropIfExists('contact');
    }
}
