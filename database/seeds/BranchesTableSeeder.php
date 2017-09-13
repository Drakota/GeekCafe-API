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

     $array = ["H1A 0A1", "H1A 0B6", "H1A 4K8"," H1A 4L2"," H1A 4L3"," H1A 4Z9", "H1A 5A1", "H1C 1J6",
     "H1C 1J7", "H1C 1K2"];

     foreach (range(1, 10) as $index) {
       $res = $client->get('http://maps.google.com/maps/api/geocode/json?address='.$array[$index - 1].'&sensor=false');
       $location = json_decode($res->getBody(), true)['results'][0]['geometry']['location'];
       Branch::create([
          'location' => $faker->address(),
          'coordinates' => $location['lat'].','.$location['lng'],
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
