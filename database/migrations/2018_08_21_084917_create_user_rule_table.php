<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserRuleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_rule', function (Blueprint $table) {
            $table->increments('id');
            $table->text('content')->nullable()->comment('服务条款');
            $table->timestamps();
        });

        $content = ['content' => ''];
        DB::table('user_rule')->insert($content);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_rule');
    }
}
