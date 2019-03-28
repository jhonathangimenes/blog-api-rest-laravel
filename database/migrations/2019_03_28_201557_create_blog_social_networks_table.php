<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogSocialNetworksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_social_networks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('url');
            $table->bigInteger('type_id')->unsigned();
            $table->foreign('type_id')->references('id')->on('type_social_networks');
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
        Schema::dropIfExists('blog_social_networks');
    }
}
