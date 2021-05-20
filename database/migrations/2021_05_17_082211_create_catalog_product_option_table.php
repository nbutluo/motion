<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatalogProductOptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catalog_product_option', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->Increments('id');
            $table->string('sku')->nullable()->comment('SKU');
            $table->integer('product_id')->default(0)->comment('Option ID');
            $table->string('title')->nullable()->comment('loctek_option_type_id');
            $table->text('description')->nullable()->comment('shipping information');
            $table->string('type')->nullable()->comment('');
            $table->smallInteger('is_active')->nullable()->comment('Layer');
            $table->integer('sort_order')->default(0)->comment('Sort Order');
            $table->text('image')->nullable()->comment('Image');
            $table->string('option_color')->nullable()->comment('Option Color');
            $table->string('option_size')->nullable()->comment('Option Size');
            $table->text('dependency')->nullable()->comment('Dependency options');
            $table->smallInteger('stocks')->default(0)->comment('OUT OF STOCK   0 has 1 no stock   default 0');
            $table->smallInteger('pre_sale')->default(0)->comment('Is Pre Sale  0 no 1 yes   default 0');
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
        Schema::dropIfExists('catalog_product_option');
    }
}
