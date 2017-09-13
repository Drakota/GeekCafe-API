<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use App\Http\Models\ItemType;
use Faker\Factory as Faker;

class ItemTypesTableSeeder extends Seeder {

  public function run()
  {
     $faker = Faker::create();

     $types = ['Cafés', 'Pâtisseries', 'Crêpes', 'Fondues'];

     foreach (range(1, 4) as $index) {
       ItemType::create([
          'name' => $types[$index - 1],
          'image_id' => rand(2, 110),
       ]);
     }
  }
}
