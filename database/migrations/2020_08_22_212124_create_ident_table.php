<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIdentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ident', function (Blueprint $table) {
            $table->string('identify')->primary()->comment('标识（手机号 邮箱 用户名或第三方应用的唯一标识）');
            $table->string('type')->default('')->comment('登陆类型,username,email,phone,wechat');
            $table->unsignedBigInteger('user_id')->index()->comment('用户uuid');
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
        Schema::dropIfExists('ident');
    }
}
