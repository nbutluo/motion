<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatalogProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catalog_product', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('name')->nullable()->comment('Product Name');
            $table->string('sku', 64)->nullable()->comment('SKU');
            $table->smallInteger('category_id')->default(0)->comment('Parent Category ID');
            $table->longText('description')->nullable()->comment('Description');
            $table->longText('description_mobile')->nullable()->comment('Description Mobile');
            $table->longText('parameters')->nullable()->comment('Parameters');
            $table->longText('short_description')->nullable()->comment('Short Description');
            $table->string('url_key')->nullable()->comment('Url Key');
            $table->decimal('price')->nullable()->comment('Price');
            $table->string('relate_ids', 100)->nullable()->comment('Relate Ids');
            $table->integer('position')->default(0)->comment('Position');
            $table->tinyInteger('is_active')->default(0)->comment('Is Active');
            $table->text('image')->nullable()->comment('Image');
            $table->string('image_label')->nullable()->comment('Image Label');
            $table->string('small_image')->nullable()->comment('Small Image');
            $table->string('small_image_label')->nullable()->comment('Small Image Label');
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
        Schema::dropIfExists('catalog_product');
    }
}
