<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediumSourceCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medium_source_category', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->Increments('id');
            $table->string('name')->nullable()->comment('Category Name');
            $table->integer('parent_id')->default(0)->comment('Parent ID');
            $table->string('identity')->default('')->comment('Identity');
            $table->tinyInteger('media_type')->default(0)->comment('Media Type');
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
        Schema::dropIfExists('medium_source_category');
    }
}
