<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoodImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('good_images', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('自增id');
            $table->string('description')->nullable()->comment('商品图片描述');
            $table->unsignedBigInteger('good_id')->index()->comment('外键商品id');
            $table->string('image')->comment('商品图片');
            $table->boolean('cover')->default(true)->comment('商品封面-浏览的第一张图片');
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
        Schema::dropIfExists('good_images');
    }
}
