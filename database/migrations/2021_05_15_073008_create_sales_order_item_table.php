<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesOrderItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_order_item', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->Increments('id');
            $table->integer('order_id')->unsigned()->default(0)->comment('Order Id');
            $table->integer('product_id')->unsigned()->nullable()->comment('Product Id');
            $table->string('product_type')->nullable()->comment('Product Type');
            $table->text('product_options')->nullable()->comment('Product Options');
            $table->decimal('weight',12,4)->nullable()->comment('Weight');
            $table->smallInteger('is_virtual')->unsigned()->nullable()->comment('Is Virtual');
            $table->string('sku')->nullable()->comment('Sku');
            $table->string('name')->nullable()->comment('Name');
            $table->text('description')->nullable()->comment('Description');
            $table->text('applied_rule_ids')->nullable()->comment('Applied Rule Ids');
            $table->text('additional_data')->nullable()->comment('Additional Data');
            $table->smallInteger('is_qty_decimal')->unsigned()->nullable()->comment('Is Qty Decimal');
            $table->smallInteger('no_discount')->unsigned()->default(0)->comment('No Discount');
            $table->decimal('base_cost',12,4)->nullable()->comment('Base Cost');
            $table->decimal('price',12,4)->default('0.0000')->comment('Price');
            $table->decimal('base_price',12,4)->default('0.0000')->comment('Base Price');
            $table->decimal('original_price',12,4)->nullable()->comment('Original Price');
            $table->decimal('base_original_price',12,4)->nullable()->comment('Base Original Price');
            $table->decimal('qty_ordered',12,4)->default('0.0000')->comment('Qty Ordered');
            $table->decimal('tax_percent',12,4)->default('0.0000')->comment('Tax Percent');
            $table->decimal('tax_amount',12,4)->default('0.0000')->comment('Tax Amount');
            $table->decimal('base_tax_amount',12,4)->default('0.0000')->comment('Base Tax Amount');
            $table->decimal('tax_invoiced',12,4)->default('0.0000')->comment('Tax Invoiced');
            $table->decimal('base_tax_invoiced',12,4)->default('0.0000')->comment('Base Tax Invoiced');
            $table->decimal('discount_percent',12,4)->default('0.0000')->comment('Discount Percent');
            $table->decimal('discount_invoiced',12,4)->default('0.0000')->comment('Discount Invoiced');
            $table->decimal('base_discount_invoiced',12,4)->default('0.0000')->comment('Base Discount Invoiced');
            $table->decimal('amount_refunded',12,4)->default('0.0000')->comment('Amount Refunded');
            $table->decimal('base_amount_refunded',12,4)->default('0.0000')->comment('Base Amount Refunded');
            $table->decimal('row_total',12,4)->default('0.0000')->comment('Row Total');
            $table->decimal('base_row_total',12,4)->default('0.0000')->comment('Base Row Total');
            $table->decimal('row_invoiced',12,4)->default('0.0000')->comment('Row Invoiced');
            $table->decimal('base_row_invoiced',12,4)->default('0.0000')->comment('Base Row Invoiced');
            $table->decimal('row_weight',12,4)->default('0.0000')->comment('Row Weight');
            $table->decimal('price_incl_tax',12,4)->nullable()->comment('Price Incl Tax');
            $table->decimal('base_price_incl_tax',12,4)->nullable()->comment('Base Price Incl Tax');
            $table->decimal('row_total_incl_tax',12,4)->nullable()->comment('Row Total Incl Tax');
            $table->decimal('base_row_total_incl_tax',12,4)->nullable()->comment('Base Row Total Incl Tax');
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
        Schema::dropIfExists('sales_order_item');
    }
}
