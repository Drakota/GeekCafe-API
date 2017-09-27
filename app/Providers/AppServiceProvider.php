<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use App\Http\Models\ItemPrice;

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
