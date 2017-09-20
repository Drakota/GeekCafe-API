<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemSubItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_subitems', function (Blueprint $table) {
          $table->integer('item_id')->unsigned();
          $table->foreign('item_id')->references('id')->on('items');
          $table->integer('subitem_id')->unsigned();
          $table->foreign('subitem_id')->references('id')->on('subitems');
          $table->primary(array('item_id', 'subitem_id'));
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
        Schema::dropIfExists('item_subitems');
    }
}
