<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_prices', function (Blueprint $table) {
          $table->increments('id');
          $table->double('price');
          $table->integer('item_id')->unsigned();
          $table->foreign('item_id')->references('id')->on('items');
          $table->integer('size_id')->unsigned()->nullable();
          $table->foreign('size_id')->references('id')->on('item_sizes');
          $table->timestamps();
          $table->softDeletes();
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
        Schema::dropIfExists('item_prices');
    }
}
