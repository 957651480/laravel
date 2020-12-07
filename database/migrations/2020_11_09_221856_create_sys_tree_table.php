<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysTreeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_tree', function (Blueprint $table) {
            $table->id();
            $table->string('tag')->comment('标签');
            $table->string('name')->comment('名称');
            $table->string('value')->comment('名称对应的值');
            $table->unsignedInteger('pid')->comment('父id');
            $table->unsignedTinyInteger('deep')->comment('深度');
            $table->string('path',255)->comment('路径');
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
        Schema::dropIfExists('sys_tree');
    }
}
