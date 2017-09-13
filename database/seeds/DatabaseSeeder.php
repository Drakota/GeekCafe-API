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
      DB::table('branches')->truncate();
      $this->call('BranchesTableSeeder');
      
      $this->call('ItemSizesTableSeeder');
      DB::table('items_sizes')->truncate();
      $this->call('ItemsTableSeeder');
      DB::table('items')->truncate();
      $this->call('ItemsTypesTableSeeder');
      DB::table('item_types')->truncate();
      $this->call('SubitemsTableSeeder');
      DB::table('subitems')->truncate();
      $this->call('ItemSubitemsTableSeeder');
      DB::table('item_subitems')->truncate();
    }
}
