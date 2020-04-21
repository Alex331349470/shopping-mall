<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('自增id');
            $table->string('name')->nullable()->comment('微信昵称');
            $table->string('phone', 11)->nullable()->unique()->comment('用户手机号');
            $table->string('avatar')->nullable()->comment('微信头像');
            $table->string('password')->nullable()->comment('登录密码');
            $table->string('session_key')->nullable()->comment('小程序session_key');
            $table->string('open_id')->nullable()->comment('小程序open_id');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
