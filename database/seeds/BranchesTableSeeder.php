<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Http\Models\Branch;
use Faker\Factory as Faker;

class BranchesTableSeeder extends Seeder {

  public function run()
  {
     $faker = Faker::create();
     $client = new \GuzzleHttp\Client();

     $array = ["45.6524306, -73.5012086", "45.6767923, -73.49411520000001", "45.6766222, -73.50982549999999"," 45.6555163, -73.5041162",
     "45.655459, -73.5037291","45.6952234, -73.4857389", "45.69622529999999, -73.48430139999999", "45.6666488, -73.5383547",
     "45.670518, -73.5414333", "45.6588352, -73.5434988"];

     foreach (range(1, 10) as $index) {
       Branch::create([
          'location' => $faker->address(),
          'coordinates' => $array[$index - 1],
          'num_tax1' => $faker->ean13(),
          'email' => $faker->email(),
          'phone' => $faker->phoneNumber(),
          'manager_name' => $faker->name(),
          'manager_email' => $faker->email(),
          'manager_phone' => $faker->phoneNumber(),
          'image_id' => rand(2, 110),
       ]);
     }
  }
}
