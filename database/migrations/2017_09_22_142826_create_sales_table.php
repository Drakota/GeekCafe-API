<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('user_id')->unsigned();
          $table->foreign('user_id')->references('id')->on('users');
          $table->boolean('payed')->default(0);
          $table->float('amount', 8, 2)->default(0);
          $table->float('discount_off', 8, 2)->default(0);
          $table->boolean('is_active')->default(1);
          $table->integer('branch_id')->unsigned();
          $table->foreign('branch_id')->references('id')->on('branches');
          $table->integer('counter_id')->unsigned()->nullable();
          $table->foreign('counter_id')->references('id')->on('counters');
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
        Schema::dropIfExists('sales');
    }
}
