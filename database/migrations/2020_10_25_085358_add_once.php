<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOnce extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // ユーザテーブル追加
            $table->string('nickname', 255)->after('password');
            $table->string('work', 255)->after('nickname');
            $table->string('sex', 1)->after('work');
            $table->string('prefecture', 2)->after('sex');
            $table->string('city', 50)->after('prefecture');
            $table->string('quit_flg', 1)->after('city')
            ->default('0');
            $table->string('user_type', 1)->after('quit_flg')
            ->default('1');
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
            //
            $table->dropColumn('nickname');
            $table->dropColumn('work');
            $table->dropColumn('sex');
            $table->dropColumn('prefecture');
            $table->dropColumn('city');
        });
    }
}
