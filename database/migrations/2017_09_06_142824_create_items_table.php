<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
          $table->increments('id');
          $table->string('name');
          $table->text('description');
          $table->double('price');
          $table->string('type_id');
          $table->foreign('type_id')->references('id')->on('item_types');
          $table->string('size_id')->nullable();
          $table->foreign('size_id')->references('id')->on('item_sizes');
          $table->string('image_id');
          $table->foreign('image_id')->references('id')->on('images');
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
        Schema::dropIfExists('items');
    }
}
