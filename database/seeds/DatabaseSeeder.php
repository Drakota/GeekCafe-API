<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::statement('SET FOREIGN_KEY_CHECKS=0');
      DB::table('users')->truncate();
      $this->call('UsersTableSeeder');
      DB::table('images')->truncate();
      $this->call('ImagesTableSeeder');
    }
}
