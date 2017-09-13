<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use App\Http\Models\Subitem;
use Faker\Factory as Faker;

class SubitemsTableSeeder extends Seeder {

  public function run()
  {
     $faker = Faker::create();

     $free = ['Lait', 'Sucre', 'Crème'];
     $nonfree = ['Chocolat', 'Fraises', 'Framboises', 'Bleuets', 'Bananes', 'Chocolat au lait', 'Chocolat Blanc'];

     foreach (range(1, count($free)) as $index) {
       Subitem::create([
          'name' => $free[$index - 1],
          'image_id' => rand(2, 110),
       ]);
     }
     foreach (range(1, count($nonfree)) as $index) {
       Subitem::create([
          'name' => $nonfree[$index - 1],
          'price' => rand(10, 60) / 10,
          'image_id' => rand(2, 110),
       ]);
     }
  }
}
