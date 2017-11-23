<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
          $table->increments('id');
          $table->string('first_name');
          $table->string('last_name');
          $table->string('email')->unique();
          $table->string('password')->nullable();
          $table->string('gender');
          $table->date('birth_date');
          $table->string('phone')->nullable();
          $table->integer('points')->default(0);
          $table->string('device_token', 2000)->nullable();
          $table->string('facebook_id', 300)->nullable();
          $table->string('stripe_cus', 300)->nullable();
          $table->string('remember_token', 255)->nullable();
          $table->boolean('is_admin')->default(0);
          $table->boolean('is_employee')->default(0);
          $table->string('image_id')->default(1);
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
        Schema::dropIfExists('users');
    }
}
