<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banner', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('sort')->default(0)->comment('排序');
            $table->string('title')->default('')->comment('标题');
            $table->unsignedInteger('image_id')->default(0)->comment('图片id');
            $table->string('link')->default('')->comment('链接');
            $table->unsignedTinyInteger('show')->default(10)->comment('是否显示：10显示,20隐藏');
            $table->softDeletes()->comment('删除时间');
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
        Schema::dropIfExists('banner');
    }
}
