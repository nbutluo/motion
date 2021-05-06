<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatalogCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catalog_category', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('name')->default('0')->comment('Category Name');
            $table->integer('parent_id')->default(0)->comment('Parent ID');
            $table->string('identity')->nullable()->comment('Identity');
            $table->integer('position')->default(0)->comment('Position');
            $table->integer('level')->default(0)->comment('Tree Level');
            $table->string('description')->nullable()->comment('Description');
            $table->tinyInteger('is_active')->default(0)->comment('Is Active');
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
        Schema::dropIfExists('catalog_category');
    }
}
