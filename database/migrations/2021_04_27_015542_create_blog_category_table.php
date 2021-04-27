<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_category', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('category_id');
            $table->string('title')->nullable()->comment('Category Title');
            $table->text('keywords')->nullable()->comment('Category Meta Keywords');
            $table->string('identifier',100)->nullable()->comment('Category String Identifier');
            $table->string('content_heading')->nullable()->comment('Category Content Heading');
            $table->mediumText('content')->nullable()->comment('Category Content');
            $table->string('path')->nullable()->comment('Category Path');
            $table->smallInteger('position')->default(0)->comment('Category Position');
            $table->smallInteger('include_in_menu')->nullable()->comment('Category In Menu');
            $table->smallInteger('is_active')->default(1)->comment('Is Category Active');
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
        Schema::dropIfExists('blog_category');
    }
}
