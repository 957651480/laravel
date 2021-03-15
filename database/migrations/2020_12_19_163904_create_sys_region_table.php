<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysRegionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_region', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('pid')->default(0)->comment('父id');
            $table->string('name')->default('')->comment('名称');
            $table->unsignedInteger('deep')->default(1)->comment('层级');
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
        Schema::dropIfExists('sys_region');
    }
}
