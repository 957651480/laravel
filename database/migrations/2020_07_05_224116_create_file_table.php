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
            $table->id();
            $table->string('name')->comment('文件名');
            $table->string('path')->comment('文件上传路径');
            $table->unsignedInteger('group_id')->comment('分组id');
            $table->unsignedInteger('company_id')->comment('公司id');
            $table->unsignedInteger('extension')->comment('文件扩展名');
            $table->unsignedInteger('mime_type')->comment('文件mine_type');
            $table->unsignedInteger('size')->comment('文件大小');
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
