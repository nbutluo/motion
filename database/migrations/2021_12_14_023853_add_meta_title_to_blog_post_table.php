<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMetaTitleToBlogPostTable extends Migration
{
    public function up()
    {
        Schema::table('blog_post', function (Blueprint $table) {
            $table->string('meta_title')->nullable()->after('keywords');
        });
    }

    public function down()
    {
        Schema::table('blog_post', function (Blueprint $table) {
            $table->dropColumn('meta_title');
        });
    }
}
