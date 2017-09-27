<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaleSubitemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_subitems', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('sale_item_id')->unsigned();
          $table->foreign('sale_item_id')->references('id')->on('sale_items');
          $table->integer('subitem_id')->unsigned();
          $table->foreign('subitem_id')->references('id')->on('subitems');
          $table->integer('sale_id')->unsigned();
          $table->foreign('sale_id')->references('id')->on('sales');
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
        Schema::dropIfExists('sale_subitems');
    }
}
