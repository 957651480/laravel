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
        Schema::create('excavator', function (Blueprint $table)
        {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedBigInteger('brand_id');
            $table->string('model')->default('');
            $table->string('method')->default('');
            $table->unsignedInteger('date_of_production')->default(0);
            $table->unsignedBigInteger('duration_of_use')->default(0);
            $table->string('equipment_operation')->default('');
            $table->string('motor_brand')->default('');
            $table->string('motor_model')->default('');
            $table->string('motor_rate_of_work')->default('')->comment('功率');
            $table->string('hydraulic_pump_rand')->default('')->comment('');
            $table->string('hydraulic_pump_model')->default('')->comment('');
            $table->unsignedBigInteger('hydraulic_pump_flow')->default(0)->comment('');
            $table->unsignedBigInteger('video_id')->default(0)->comment('');
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::create('excavator_image', function (Blueprint $table)  {
            $table->unsignedBigInteger('excavator_id');
            $table->unsignedBigInteger('image_id');
            $table->timestamps();
            $table->index(['excavator_id','image_id'], 'excavator_image_id');

            $table->foreign('excavator_id')
                ->references('id')
                ->on('excavator')
                ->onDelete('cascade');

            $table->foreign('image_id')
                ->references('id')
                ->on('file')
                ->onDelete('cascade');

            $table->primary(['excavator_id', 'image_id'],
                'model_has_permissions_permission_model_type_primary');
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
        Schema::dropIfExists('excavator_image');
    }
}
