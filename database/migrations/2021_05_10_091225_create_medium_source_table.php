<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediumSourceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medium_source', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->Increments('id');
            $table->string('title')->nullable()->comment('Media Title');
            $table->string('description')->nullable()->comment('Media Description');
            $table->smallInteger('media_type')->default(1)->comment('Media Type');
            $table->integer('category_id')->default(0)->comment('Category Id');
            $table->text('lable')->nullable()->comment('Media Lable');
            $table->string('media_url')->nullable()->comment('Media URL');
            $table->string('media_location')->nullable()->comment('Media Location');
            $table->text('media_links')->nullable()->comment('Media Links');
            $table->tinyInteger('is_active')->default(0)->comment('Media Active');
            $table->integer('position')->default(0)->comment('Sort Order');
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
        Schema::dropIfExists('medium_source');
    }
}
