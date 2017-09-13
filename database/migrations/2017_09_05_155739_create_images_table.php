<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('images', function (Blueprint $table) {
        $table->string('id');
        $table->primary('id');
        $table->timestamps();
        $table->softDeletes();
      });
      DB::statement("ALTER TABLE images ADD image LONGBLOB");
      DB::statement("ALTER TABLE images MODIFY COLUMN image LONGBLOB AFTER ID");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('images');
    }
}
