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
            $table->integerIncrements('id')->comment('地区id');
            $table->string('name')->default('')->index()->comment('名称');
            $table->integer('parent_id')->default(0)->index()->comment('父id');
            $table->integer('level')->default(1)->comment('层级');
            $table->string('path')->default('')->comment('path');
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
