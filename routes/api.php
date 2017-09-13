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
