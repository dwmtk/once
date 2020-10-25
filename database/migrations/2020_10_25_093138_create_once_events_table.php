<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOnceEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255);
            $table->longText('content');
            $table->string('category', 50);
            $table->longText('image')
            ->nullable()
            ->default(null);
            $table->string('start', 12);
            $table->string('end', 12);
            $table->integer('capacity');
            $table->string('closed_flg', 1)
            ->default('0');
            $table->string('stop_flg', 1)
            ->default('0');
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
        Schema::dropIfExists('events');
    }
}
