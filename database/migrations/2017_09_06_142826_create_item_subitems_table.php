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
          $table->string('item_id');
          $table->foreign('item_id')->references('id')->on('items');
          $table->string('subitem_id');
          $table->foreign('subitem_id')->references('id')->on('subitems');
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
