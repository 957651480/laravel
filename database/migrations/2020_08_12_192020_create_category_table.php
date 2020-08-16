<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default('')->comment('名称');
            $table->unsignedInteger('parent_id')->default(0)->comment('父类id');
            $table->string('seo_title')->default('')->comment('seo标题');
            $table->string('seo_keyword')->default('')->comment('seo关键词');
            $table->string('seo_description')->default('')->comment('seo描述');
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
        Schema::dropIfExists('category');
    }
}
