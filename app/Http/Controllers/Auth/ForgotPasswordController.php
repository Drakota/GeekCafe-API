<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Http\Transformers\Json;
use App\Http\Models\User;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Dingo\Api\Exception\StoreResourceFailedException;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
     */
    use SendsPasswordResetEmails;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getResetToken(Request $request)
    {
        $rules = [
          'email' => ['required', 'email']
        ];
        $payload = app('request')->only('email');
        $validator = app('validator')->make($payload, $rules);
        if ($validator->fails()) {
            throw new StoreResourceFailedException('Could not create new user.', $validator->errors());
        }
        $user = User::where('email', $payload['email'])->first();
        if (!$user) {
            return response()->json([
              'message' => trans('passwords.user'),
            ], 400);
        }
        $token = $this->broker()->createToken($user);
        return response()->json(['status' => 'A confimation was sent to your email!'], 200);
    }
}
