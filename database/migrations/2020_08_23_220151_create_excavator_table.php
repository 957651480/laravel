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
            $table->string('name',255)->default('')->comment('挖机名称');
            $table->unsignedBigInteger('brand_id');
            $table->string('model')->default('');
            $table->string('method')->default('');
            $table->unsignedInteger('date_of_production')->default(0);
            $table->unsignedBigInteger('duration_of_use')->default(0);
            $table->string('equipment_operation')->default('');
            $table->string('weight')->default('')->comment('重量');
            $table->string('recommend')->default('')->comment('推荐');
            $table->string('sort')->default('')->comment('排序');
            $table->unsignedInteger('region_id')->default(0)->comment('地址');
            $table->string('motor_brand')->default('');
            $table->string('motor_model')->default('');
            $table->string('motor_rate_of_work')->default('')->comment('功率');
            $table->string('hydraulic_pump_rand')->default('')->comment('');
            $table->string('hydraulic_pump_model')->default('')->comment('');
            $table->unsignedBigInteger('hydraulic_pump_flow')->default(0)->comment('');
            $table->unsignedBigInteger('video_id')->default(0)->comment('');
            $table->mediumText('costs')->comment('费用明细');
            $table->softDeletes();
            $table->timestamps();
        });


        Schema::create('excavator_cost', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default('')->comment('名称');
            $table->unsignedBigInteger('parent_id')->default(0)->comment('父级id');
            $table->decimal('price')->default(0)->comment('价格');
            $table->softDeletes()->comment('删除时间');
            $table->timestamps();
        });

        Schema::create('excavator_image', function (Blueprint $table)  {
            $table->unsignedBigInteger('excavator_id');
            $table->unsignedBigInteger('image_id');
            $table->timestamps();
            $table->index(['excavator_id','image_id'], 'excavator_image_id');
        });

        Schema::create('excavator_cost_pivot', function (Blueprint $table)  {
            $table->unsignedBigInteger('excavator_id');
            $table->unsignedBigInteger('excavator_cost_id');
            $table->timestamps();
            $table->index(['excavator_id','excavator_cost_id'], 'excavator_cost_id');
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
        Schema::dropIfExists('excavator_cost');
        Schema::dropIfExists('excavator_image');
        Schema::dropIfExists('excavator_cost_pivot');
    }
}
