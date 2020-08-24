<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExcavatorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('excavator', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('brand_id');
            $table->string('model');
            $table->string('method');
            $table->date('date_of_production');
            $table->unsignedBigInteger('duration_of_use');
            $table->unsignedBigInteger('brand_id');
            $table->string('motor_brand');
            $table->string('motor_model');
            $table->string('motor_rate_of_work')->comment('功率');
            $table->string('hydraulic_pump_rand')->comment('');
            $table->string('hydraulic_pump_model')->comment('');
            $table->string('hydraulic_pump_flow')->comment('');
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
        Schema::dropIfExists('excavator');
    }
}
