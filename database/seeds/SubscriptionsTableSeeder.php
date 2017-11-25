<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use App\Http\Models\Subscription;
use Faker\Factory as Faker;
use Carbon\Carbon;

class SubscriptionsTableSeeder extends Seeder {

  public function run()
  {
     $discount = [1, 1.5, 3, 5];
     $point_reward = [1, 1.5, 2, 2.5];
     $title = ['Membre de Base', 'Membre Honorable', 'Membre Exclusif', 'Membre Premium'];
     $perks = ['1 café par mois', '1 café & 1 pâtisserie par mois', "1 café, 1 pâtisserie & 1 remplissage à volonté lors d'une visite par mois", "2 café, 2 pâtisserie, 3 remplissage à volonté lors d'une visite par mois"];
     $prices = [0, 5, 10, 15];
     
     $faker = Faker::create();
     foreach (range(1, 4) as $index) {
       Subscription::create([
          'perk' => $perks[$index - 1],
          'discount' => $discount[$index- 1],
          'price' => $prices[$index -1],
          'title' => $title[$index - 1],
          'point_reward' => $point_reward[$index- 1],
          'description' => $faker->realText(),
       ]);
     }
  }
}
