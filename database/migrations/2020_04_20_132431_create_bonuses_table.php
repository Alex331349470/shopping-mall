<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBonusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bonuses', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('自增id');
            $table->integer('user_id')->index()->comment('外键用户ID');
            $table->integer('order_id')->index()->comment('订单ID');
            $table->smallInteger('user_type')->default(0)->comment('0-普通客户 1-二级代销 2-一级代销');
            $table->decimal('bonus')->default(0)->comment('返利金额');
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
        Schema::dropIfExists('bonuses');
    }
}
