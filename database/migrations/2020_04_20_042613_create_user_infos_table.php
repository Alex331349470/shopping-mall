<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_infos', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('自增id');
            $table->integer('user_id')->index()->comment('外键user_id');
            $table->integer('parent_id')->nullable()->index()->comment('上级id');
            $table->smallInteger('type')->default(0)->comment('账号类别：0-普通用户,1-二级代理,2-一级代理');
            $table->smallInteger('gender')->default(0)->comment('性别:0-保密,1-男,2-女');
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
        Schema::dropIfExists('user_infos');
    }
}
