<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use App\Http\Transformers\UserTransformer;
use App\Http\Models\User;

/**
 * User resource representation.
 *
 * @Resource("Users", uri="/users")
 */
class UsersController extends BaseController
{
    public function view(Request $request)
    {
        $user = $request->user();
        return $this->response->item($user, new UserTransformer);
    }

    public function create(Request $request)
    {
        $dispatcher = app('Dingo\Api\Dispatcher');
        $payload = $request->only('email', 'password', 'first_name', 'last_name', 'device_token', 'image_id', 'phone', 'gender', 'birth_date');
        $this->validation($payload, [
          'email' => ['required', 'email', 'unique:users'],
          'password' => ['required', 'min:7'],
          'first_name' => ['required'],
          'last_name' => ['required'],
          'device_token' => ['nullable'],
          'phone' => ['nullable'],
          'gender' => ['required', Rule::in(['male', 'female', 'other'])],
          'image_id' => ['nullable', 'exists:images,id'],
          'birth_date' => ['required', 'date_format:Y-m-d', 'before:today'],
        ]);
        $unhashpass = $payload['password'];
        $payload['image_id'] = 1;
        $payload['password'] = Hash::make($payload['password']);
        $user = User::create(array_filter($payload));
        $createuser = $this->transformItem($user, new UserTransformer);
        $response = $dispatcher->raw()->json(['email' => $payload['email'], 'password' => $unhashpass])->post('token');
        $token = str_replace(['"', '}'], "", explode(':', $response->content())[1]);
        $createuser['token'] = $token;
        return $createuser;
    }

    public function modify(Request $request)
    {
        $user = $request->user();
        $payload = $request->only('image_id', 'first_name', 'last_name');
        $this->validation($payload, [
          'first_name' => ['nullable'],
          'last_name' => ['nullable'],
          'device_token' => ['nullable'],
          'image_id' => ['nullable', 'exists:images,id'],
        ]);
        $user->update(array_filter($payload));
			  $user->touch();
        return $this->response->item($user, new UserTransformer);
    }

    public function modifypassword(Request $request)
    {
        $user = $request->user();
        $payload = $request->only('password', 'newpassword');
        $this->validation($payload, [
          'password' => ['required'],
          'newpassword' => ['required',  'min:7', 'different:password'],
        ]);
        if (!Hash::check($payload['password'], $user->password)) {
          return response()->json(['status' => 'Incorrect Password!'], 401);
        }
        $user->password = Hash::make($payload['newpassword']);
        $user->touch();
        return response()->json(['status' => 'Password changed successfully!'], 200);
    }

    public function modifyemail(Request $request)
    {
        $user = $request->user();
        $payload = $request->only('email', 'password');
        $this->validation($payload, [
          'password' => ['required'],
          'email' => ['required', 'email', 'unique:users'],
        ]);
        if (!Hash::check($payload['password'], $user->password)) {
          return response()->json(['status' => 'Incorrect Password!'], 401);
        }
        $user->email = $payload['email'];
        $user->touch();
        return response()->json(['status' => 'Email changed successfully!'], 200);
    }

    public function verify()
    {
        $payload = app('request')->only('email');
        $this->validation($payload,['email' => ['required', 'email', 'unique:users'],]);
        return response()->json(['status' => 'This email is available!'], 200);
    }
    //
    // public function forgetpassword()
    // {
    //     $user = app('Dingo\Api\Auth\Auth')->user();
    // }
}