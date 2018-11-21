<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFreightRuleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('freight_rule', function (Blueprint $table) {
            $table->increments('id');
            $table->text('content')->nullable()->comment('运费规则');
            $table->timestamps();
        });

        $content = ['content' => ''];
        DB::table('freight_rule')->insert($content);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('freight_rule');
    }
}
