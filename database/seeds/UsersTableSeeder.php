<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use App\Http\Models\User;
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder {

  public function run()
  {
     $faker = Faker::create();
     $genders = ['male', 'female', 'other'];

     foreach (range(1, 5) as $index) {
       User::create([
          'email' => "account".$index."@geekcafe.com",
          'password' => Hash::make("geekcafe"),
          'gender' => $genders[rand(0, sizeof($genders) - 1)],
          'phone' => $faker->phoneNumber(),
          'birth_date' => $faker->date(),
          'first_name' => $faker->firstName(),
          'last_name' => $faker->lastName(),
       ]);
     }
  }
}
