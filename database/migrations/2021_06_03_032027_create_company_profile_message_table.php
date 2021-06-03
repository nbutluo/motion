<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyProfileMessageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_profile_message', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->Increments('id');
            $table->string('title')->nullable()->comment('Title');
            $table->text('content')->nullable()->comment('Content');
            $table->string('media_link')->nullable()->comment('Media Link');
            $table->tinyInteger('is_active')->default(1)->comment('Is Active 0:no,1:yes');
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
        Schema::dropIfExists('company_profile_message');
    }
}
