<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAfterSaleRuleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('after_sale_rule', function (Blueprint $table) {
            $table->increments('id');
            $table->text('content')->nullable()->comment('售后规则');
            $table->timestamps();
        });

        $content = ['content' => ''];
        DB::table('after_sale_rule')->insert($content);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('after_sale_rule');
    }
}
