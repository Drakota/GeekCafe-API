<?php
use Intervention\Image\ImageManagerStatic as Image;
use App\Http\Models\Image as ImageTable;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
$api = app('Dingo\Api\Routing\Router');
$api->version('v1', ['namespace' => 'App\Http\Controllers', 'middleware' => ['api.auth', 'bindings']], function ($api) {

  /**
  * UsersController
  */
  $api->put('user', 'UsersController@modify');
  $api->get('user', 'UsersController@view');
  $api->put('user/changepassword', 'UsersController@modifypassword');
  $api->put('user/changeemail', 'UsersController@modifyemail');
  $api->get('user/points', 'UsersController@points');

  /**
  * PaymentMethodsController
  */
  $api->get('user/payments', 'PaymentMethodsController@listpaymentmethod');
  $api->post('user/payment', 'PaymentMethodsController@paymentmethod');
  $api->delete('user/payment', 'PaymentMethodsController@removepaymentmethod');

  /**
  * ItemsController
  */
  $api->get('item/types', 'ItemsController@types');
  $api->get('items', 'ItemsController@index');
  $api->get('item/{item}', 'ItemsController@view');

  /**
  * PromotionsController
  */
  $api->get('promotions', 'PromotionsController@index');

  /**
  * SalesController
  */
  $api->post('checkprice', 'SalesController@checkprice');
  $api->post('order', 'SalesController@create');
  $api->get('order/{sale}', 'SalesController@view');
  $api->get('user/history', 'SalesController@history');
});
$api->version('v1', ['namespace' => 'App\Http\Controllers'], function ($api) {

  /**
  * UsersController
  */
  $api->post('user', 'UsersController@create');
  $api->post('verify', 'UsersController@verify');
});
$api->version('v1', ['namespace' => 'App\Http\Controllers\Auth'], function ($api) {
  /**
  * AuthenticationController
  */
  $api->post('token', 'AuthenticationController@token');
  $api->post('verifytoken', 'AuthenticationController@verifytoken');
  $api->post('loginfacebook', 'AuthenticationController@loginfacebook');
});

$api->version('v1', function ($api) {
  $api->get('image/{id}', function($id) {
    if(!$upload = ImageTable::find($id)) return response()->json(['status' => "Image not found!"], 404);
    $img = Image::cache(function($image) use ($upload) {
        $image->make($upload->image);
    });
    return Image::make($img)->response('jpg');
  });
});
