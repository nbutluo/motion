<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogPostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_post', function (Blueprint $table) {
            $table->bigIncrements('post_id');
            $table->string('title')->nullable()->comment('Post Title');
            $table->text('keywords')->nullable()->comment('Post Meta Keywords');
            $table->text('meta_description')->nullable()->comment('Post Meta Description');
            $table->string('identifier',100)->nullable()->comment('Post String Identifier');
            $table->string('content_heading')->nullable()->comment('Post Content Heading');
            $table->mediumText('content')->nullable()->comment('Post Content');
            $table->timestamp('publish_time')->nullable()->comment('Post Publish Time');
            $table->smallInteger('is_active')->default(1)->comment('Is Post Active');
            $table->smallInteger('include_in_recent')->default(1)->comment('Include in Recent Posts');
            $table->smallInteger('position')->default(0)->comment('Position');
            $table->string('featured_img')->default('')->comment('Thumbnail Image');
            $table->integer('author_id')->nullable()->comment('Author ID');
            $table->mediumText('media_gallery')->nullable()->comment('Media Gallery');
            $table->string('secret', 32)->nullable()->comment('Post Secret');
            $table->integer('views_count')->nullable()->comment('Post Views Count');
            $table->smallInteger('is_recent_posts_skip')->nullable()->comment('Is Post Skipped From Recent Posts');
            $table->mediumText('short_content')->nullable()->comment('Post Short Content');
            $table->smallInteger('category_id')->nullable()->comment('Is Featured Post');
            $table->string('featured_banner')->nullable()->comment('Featured Banner');
            $table->string('author_image')->nullable()->comment('Author Image');
            $table->string('blog_author')->nullable()->comment('Blog Author');
            $table->text('blog_author_description')->nullable()->comment('Blog Author Description');
            $table->smallInteger('show_in_home')->default(0)->comment('Show in Home Page');
            $table->string('image_title',80)->default('')->comment('Image title');
            $table->string('image_alt',80)->default('')->comment('image alt');
            $table->text('image_description')->nullable()->comment('image desciption');
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
        Schema::dropIfExists('blog_post');
    }
}
