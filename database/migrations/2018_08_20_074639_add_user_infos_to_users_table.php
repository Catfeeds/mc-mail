<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserInfosToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('contact_person',20)->nullable()->comment('联系人');
            $table->string('detail_place',64)->nullable()->comment('详细地址');
            $table->string('level')->default(0)->index()->comment('会员等级');
            $table->string('money')->default(0)->comment('会员余额');
            $table->string('score')->default(0)->comment('会员积分');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('contact_person');
            $table->dropColumn('detail_place');
            $table->dropColumn('level');
            $table->dropColumn('money');
            $table->dropColumn('score');
        });
    }
}
