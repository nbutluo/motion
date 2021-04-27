<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_comment', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('comment_id');
            $table->integer('parent_id')->default(0)->comment('Parent Comment ID');
            $table->integer('post_id')->default(0)->comment('Post ID');
            $table->integer('customer_id')->nullable()->comment('Customer ID');
            $table->integer('admin_id')->nullable()->comment('Admin User ID');
            $table->smallInteger('status')->default(0)->comment('Comment status');
            $table->smallInteger('author_type')->default(0)->comment('Author Type');
            $table->string('author_nickname')->default('')->comment('Comment Author Nickname');
            $table->string('author_email')->nullable()->comment('Comment Author Email');
            $table->mediumText('text')->nullable()->comment('Text');
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
        Schema::dropIfExists('blog_comment');
    }
}
