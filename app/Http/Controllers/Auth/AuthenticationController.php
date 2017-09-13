<?php
namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Models\User;
use App\Http\Models\Image;
use App\Http\Transformers\UserTransformer;

class AuthenticationController extends BaseController
{
    public function token(Request $request)
    {
        $credentials = $request->only('email', 'password');
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Invalid Credentials'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        }
        return response()->json(compact('token'));
    }
    public function verifytoken()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['error' => 'User not found'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['error' => 'The token is expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['error' => 'The token is invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['error' => 'The token is absent'], $e->getStatusCode());
        }
        $user->setVisible(['first_name','last_name', 'user_id']);
        return response()->json(compact('user'));
    }
    public function loginfacebook(Request $request)
    {
      $payload = $request->only('access_token');
      $fb = new \Facebook\Facebook([
        'app_id' => '1926447790930538',
        'app_secret' => '3851e3ab3f451b51a4d77641b8965dc6',
        'default_graph_version' => 'v2.10',
      ]);
      try {
        $response = $fb->get('/me?fields=id,first_name,last_name,email,birthday,picture.width(400).height(400),gender', $payload['access_token']);
      } catch(\Facebook\Exceptions\FacebookResponseException $e) {
        return response()->json(['error' => $e->getMessage()], 400);
        exit;
      } catch(\Facebook\Exceptions\FacebookSDKException $e) {
        return response()->json(['error' => $e->getMessage()], 400);
        exit;
      }
      $me = $response->getGraphUser();
      if ($user = User::where('facebook_id', $me['id'])->first()) {
        $token = JWTAuth::fromUser($user);
        return ['token' => $token];
      }
      else {
        $image = Image::create([
           'id' => bin2hex(openssl_random_pseudo_bytes(8)),
           'image' => $me->getProperty('picture')['url'],
        ]);
        $user = User::create([
         'email' => $me['email'],
         'gender' => $me['gender'],
         'birth_date' => $me->getBirthday(),
         'first_name' => $me['first_name'],
         'last_name' => $me['last_name'],
         'facebook_id' => $me['id'],
         'image_id' => $image->id,
        ]);
        $token = JWTAuth::fromUser($user);
        $facebookuser = $this->transformItem($user, new UserTransformer);
        $facebookuser['token'] = $token;
        return $facebookuser;
      }
    }
}
