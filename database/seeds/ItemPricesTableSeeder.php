<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use App\Http\Models\ItemPrice;
use Faker\Factory as Faker;

class ItemPricesTableSeeder extends Seeder {

    public function run()
    {
        $id = 1;
        $faker = Faker::create();
        $coffees = ['Caramel', 'Dark Mocha', 'White Chocolate', 'Java Chip', 'Mocha', 'White', 'Chai', 'Vanilla'];
        foreach (range(1, count($coffees)) as $index) {
          for ($i=0; $i < 3; $i++) {
            ItemPrice::create([
               'item_id' => $id,
               'price' => rand(10, 30) / 10 + $i,
               'size_id' => $i + 1,
            ]);
          }
          $id++;
        }
        $pastries = ['Muffin au caramel', 'Muffin aux fraises', 'Muffin au chocolat', 'Croissant au beurre'];
        foreach (range(1, count($pastries)) as $index) {
          ItemPrice::create([
             'item_id' => $id,
             'price' => rand(10, 60) / 10,
          ]);
          $id++;
        }
        for ($y=0; $y < 4; $y++) {
          ItemPrice::create([
             'item_id' => $id,
             'price' => 1 + $y,
             'size_id' => 4 + $y,
          ]);
        }
   }
}
