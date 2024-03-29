<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use App\Http\Models\ItemPrice;
use App\Http\Models\Branch;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
      Schema::defaultStringLength(191);
      app('Dingo\Api\Exception\Handler')->register(function (\Illuminate\Database\Eloquent\ModelNotFoundException $e){
          return \Response::make(['status' => 'Resource not found!'], 404);
      });
      Validator::extend('validSubitem', function ($attribute, $value, $parameters, $validator) {
          $item = ItemPrice::find($parameters[0])->item;
          return in_array($value, $item->subitems->pluck('subitem_id')->all());
      });
      Validator::extend('validCounter', function ($attribute, $value, $parameters, $validator) {
          if (!isset($validator->getData()['branch_id'])) return false;
          if(!$branch = Branch::find($validator->getData()['branch_id'])) return false;
          $counters = $branch->counters;
          return in_array($value, $counters->pluck('id')->all());
      });
      Validator::extend('empty_when', function ($attribute, $value, $parameters, $validator) {
          foreach ($parameters as $key)
          {
              if (!empty(Input::get($key)))
              {
                  return false;
              }
          }
          return true;
      });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
