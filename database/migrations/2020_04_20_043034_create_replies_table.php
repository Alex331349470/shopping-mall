<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('replies', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('自增id');
            $table->integer('good_id')->index()->comment('外键商品id');
            $table->integer('user_id')->index()->comment('外键用户id');
            $table->integer('order_id')->index()->comment('外键订单id');
            $table->json('images')->nullable()->comment('评论图片json数组');
            $table->text('content')->nullable()->comment('评论描述');
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
        Schema::dropIfExists('replies');
    }
}
