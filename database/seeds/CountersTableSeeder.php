<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use App\Http\Models\Counter;
use Faker\Factory as Faker;

class CountersTableSeeder extends Seeder {

  public function run()
  {
     $faker = Faker::create();
     foreach (range(1, 10) as $index) {
       foreach (range(1, 15) as $indextable) {
         Counter::create([
            'label' => 'Table '. $indextable,
            'branch_id' => $index,
            'image_id' => 'qrcode',
         ]);
       }
     }
  }
}
