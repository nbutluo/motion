<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBulkOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('bulk_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email');
            $table->string('company');
            $table->string('message')->nullable();
            $table->unsignedInteger('blog_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bulk_orders');
    }
}
