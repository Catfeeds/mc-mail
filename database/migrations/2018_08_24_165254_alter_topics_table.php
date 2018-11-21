<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('topics', function (Blueprint $table) {
            $table->unsignedInteger('mcategory_id')->comment('分类id');
            $table->string('label','200')->comment('分类id');
            $table->string('killtime','200')->comment('秒杀点');
            $table->unsignedInteger('canceltime')->comment('多少时间后未付款取消订单');
            $table->unsignedInteger('status')->comment('专题状态');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
