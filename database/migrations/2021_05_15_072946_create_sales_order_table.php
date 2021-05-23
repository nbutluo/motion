<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_order', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->Increments('id');
            $table->string('status')->nullable()->comment('Status');
            $table->integer('customer_id')->unsigned()->nullable()->comment('Customer Id');
            $table->string('customer_name')->nullable()->comment('Customer Name');
            $table->string('customer_email')->nullable()->comment('Customer Email');
            $table->integer('salesman')->nullable()->comment('Salesman ID');
            $table->decimal('base_grand_total',12,4)->nullable()->comment('Base Grand Total');
            $table->decimal('base_total_paid',12,4)->nullable()->comment('Base Total Paid');
            $table->decimal('grand_total',12,4)->nullable()->comment('Grand Total');
            $table->decimal('total_paid',12,4)->nullable()->comment('Total Paid');
            $table->string('increment_id')->nullable()->comment('Increment Id');
            $table->string('base_currency_code')->nullable()->comment('Base Currency Code');
            $table->string('order_currency_code')->nullable()->comment('Order Currency Code');
            $table->string('shipping_name')->nullable()->comment('Shipping Name');
            $table->string('billing_name')->nullable()->comment('Billing Name');
            $table->string('billing_address')->nullable()->comment('Billing Address');
            $table->string('shipping_address')->nullable()->comment('Shipping Address');
            $table->string('shipping_information')->nullable()->comment('Shipping Method Name');
            $table->decimal('subtotal',12,4)->nullable()->comment('Subtotal');
            $table->decimal('shipping_and_handling',12,4)->nullable()->comment('Shipping and handling amount');
            $table->string('payment_method')->nullable()->comment('Payment Method');
            $table->decimal('total_refunded',12,4)->nullable()->comment('Total Refunded');
            $table->tinyInteger('mailchimp_flag')->default(0)->comment('Retrieved from Mailchimp');
            $table->text('delivery_date')->nullable()->comment('source: how did you hear from');
            $table->integer('placed_order')->nullable()->comment('I placed this order for ?');
            $table->decimal('route_tax_fee',12,4)->default('0.00')->comment('Route Tax Fee');
            $table->smallInteger('order_approval_status')->unsigned()->default(0)->comment('order_approval_status');
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
        Schema::dropIfExists('sales_order');
    }
}
