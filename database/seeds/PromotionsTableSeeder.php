<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use App\Http\Models\Promotion;
use Faker\Factory as Faker;
use Carbon\Carbon;

class PromotionsTableSeeder extends Seeder {

  public function run()
  {

    $reduction = ['5.00', '10%', '2.50', '15%', '1.23', '100%', '2.00'];

     $faker = Faker::create();
     foreach (range(1, 10) as $index) {
       Promotion::create([
          'item_price_id' => $index + rand(0, 30),
          'description' => $faker->realText(),
          'available_per_user' => rand(1, 3),
          'reduction' => $reduction[rand(0, count($reduction) - 1)],
          'start_date' => Carbon::now(),
          'end_date' => Carbon::now()->addDays(rand(20, 40)),
       ]);
     }
  }
}
