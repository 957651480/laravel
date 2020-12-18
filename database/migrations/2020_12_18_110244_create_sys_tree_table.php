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
            $table->unsignedInteger('pid')->default(0);
            $table->unsignedInteger('deep')->default(1);
            $table->string('key')->default('')->comment('标识');
            $table->string('name')->default('')->comment('名称');
            $table->string('value')->default('')->comment('值');
            $table->string('path')->default('')->comment('路径');
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
        Schema::dropIfExists('sys_tree');
    }
}
