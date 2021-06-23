<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediumBannerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medium_banner', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->Increments('id');
            $table->string('page_name')->nullable()->comment('Page Name');
            $table->string('description')->nullable()->comment('Description');
            $table->string('media_url')->nullable()->comment('Media Url');
            $table->string('banner_alt')->default('')->comment('Banner Alt');
            $table->tinyInteger('is_active')->default(1)->comment('Is Active');
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
        Schema::dropIfExists('medium_banner');
    }
}
