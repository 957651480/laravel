<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->string('name')->default('')->comment('文件名');
            $table->string('path')->default('')->comment('文件上传路径');
            $table->unsignedInteger('group_id')->default(0)->comment('分组id');
            $table->unsignedInteger('company_id')->default(0)->comment('公司id');
            $table->string('extension',50)->default('')->comment('文件扩展名');
            $table->string('mime_type',50)->default('')->comment('文件mine_type');
            $table->unsignedInteger('size')->default(0)->comment('文件大小');
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
        Schema::dropIfExists('file');
    }
}
