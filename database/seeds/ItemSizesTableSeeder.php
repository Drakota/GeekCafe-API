<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use App\Http\Models\ItemSize;
use Faker\Factory as Faker;

class ItemSizesTableSeeder extends Seeder {

  public function run()
  {
     $faker = Faker::create();

     $types = ['S', 'M', 'L', '1 choix', '2 choix', '3 choix'];

     foreach (range(1, 6) as $index) {
       ItemSize::create([
          'name' => $types[$index - 1],
       ]);
     }
  }
}
