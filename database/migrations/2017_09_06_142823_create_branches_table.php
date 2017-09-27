<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branches', function (Blueprint $table) {
          $table->increments('id');
          $table->string('location');
          $table->string('coordinates');
          $table->string('num_tax1');
          $table->string('num_tax2')->nullable();
          $table->string('email');
          $table->string('phone');
          $table->string('manager_name');
          $table->string('manager_email');
          $table->string('manager_phone');
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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::dropIfExists('branches');
    }
}
