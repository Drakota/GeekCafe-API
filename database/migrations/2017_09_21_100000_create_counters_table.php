<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('counters', function (Blueprint $table) {
        $table->increments('id');
        $table->string('label');
        $table->integer('branch_id')->unsigned();
        $table->foreign('branch_id')->references('id')->on('branches');
        $table->string('image_id');
        $table->foreign('image_id')->references('id')->on('images');
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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::dropIfExists('counters');
    }
}
