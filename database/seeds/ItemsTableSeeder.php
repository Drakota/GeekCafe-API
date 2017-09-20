<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use App\Http\Models\Item;
use Faker\Factory as Faker;

class ItemsTableSeeder extends Seeder {

  public function run()
  {
     $faker = Faker::create();

     $coffees = ['Caramel', 'Dark Mocha', 'White Chocolate', 'Java Chip', 'Mocha', 'White', 'Chai', 'Vanilla'];
     foreach (range(1, count($coffees)) as $index) {
       for ($i=0; $i < 4; $i++) {
         Item::create([
            'name' => $coffees[$index - 1],
            'description' => $faker->realText(),
            'price' => rand(10, 30) / 10 + $i,
            'type_id' => 1,
            'size_id' => $i + 1,
            'image_id' => rand(2, 110),
         ]);
       }
     }
     $pastries = ['Muffin au caramel', 'Muffin aux fraises', 'Muffin au chocolat', 'Croissant au beurre'];
     foreach (range(1, count($pastries)) as $index) {
       Item::create([
          'name' => $pastries[$index - 1],
          'description' => $faker->realText(),
          'price' => rand(10, 60) / 10,
          'type_id' => 2,
          'image_id' => rand(2, 110),
       ]);
     }
     for ($y=0; $y < 4; $y++) {
       Item::create([
          'name' => 'Crêpe',
          'description' => $faker->realText(),
          'price' => 1 + $y,
          'type_id' => 3,
          'size_id' => 4 + $y,
          'image_id' => rand(2, 110),
       ]);
     }
  }
}
