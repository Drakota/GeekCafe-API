<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('promotions', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('item_id')->unsigned();
        $table->foreign('item_id')->references('id')->on('items');
        $table->text('description');
        $table->integer('available_per_user');
        $table->string('reduction');
        $table->date('start_date');
        $table->date('end_date');
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
      Schema::dropIfExists('promotions');
    }
}
