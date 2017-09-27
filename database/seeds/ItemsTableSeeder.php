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
         Item::create([
            'name' => $coffees[$index - 1],
            'description' => $faker->realText(),
            'type_id' => 1,
            'image_id' => rand(2, 110),
         ]);
     }
     $pastries = ['Muffin au caramel', 'Muffin aux fraises', 'Muffin au chocolat', 'Croissant au beurre'];
     foreach (range(1, count($pastries)) as $index) {
       Item::create([
          'name' => $pastries[$index - 1],
          'description' => $faker->realText(),
          'type_id' => 2,
          'image_id' => rand(2, 110),
       ]);
     }
     Item::create([
        'name' => 'Crêpe',
        'description' => $faker->realText(),
        'type_id' => 3,
        'image_id' => rand(2, 110),
     ]);
  }
}
