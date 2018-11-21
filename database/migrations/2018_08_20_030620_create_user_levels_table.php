<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_levels', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('level')->unique()->comment('会员等级，越大等级越高');
            $table->string('name', 32)->unique()->comment('等级名称');
            $table->string('upgrade_condition', 256)->comment('升级条件说明');
//            $table->tinyInteger('upgrade_way')->default(1)->comment('升级方式：1手动2自动');
            $table->unsignedTinyInteger('date_num')->default(0)->comment('满足天数');
            $table->unsignedInteger('data_money')->default(0)->comment('每日消费金额');
            $table->string('brands')->nullable()->comment('分类条件');
            $table->unsignedInteger('brands_money')->default(0)->comment('分类累计消费金额');
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
        Schema::dropIfExists('user_levels');
    }
}
