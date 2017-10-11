<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use App\Http\Models\PointValue;
use Faker\Factory as Faker;

class PointValueTableSeeder extends Seeder {

  public function run()
  {
     PointValue::create([
        'value' => 0.05,
     ]);
  }
}
