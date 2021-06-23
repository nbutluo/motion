<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessSolutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_solutions', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->Increments('id');
            $table->tinyInteger('category_type')->default(1)->comment('1:Home Solutions  2:Office Solution');
            $table->string('title')->nullable()->comment('Title');
            $table->text('content')->nullable()->comment('content');
            $table->tinyInteger('is_active')->default(1)->comment('Is Active');
            $table->integer('position')->default(0)->comment('Position');
            $table->string('media_link')->nullable()->comment('media Link');
            $table->string('media_alt')->nullable()->comment('Media Alt');
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
        Schema::dropIfExists('business_solutions');
    }
}
