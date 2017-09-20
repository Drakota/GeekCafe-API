<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Route;
use Illuminate\Http\Request;
use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use Carbon\Carbon;
use App\Http\Models\License;

class PaymentMethodsController extends BaseController
{
    public function __construct()
    {
      \Stripe\Stripe::setApiKey(env('STRIPE_KEY'));
    }

    public function paymentmethod(Request $request)
    {
      if ($request->only('card_token')['card_token'] === null) {
        return response()->json(['error' => 'Please provide a card token!'], 403);
      }
      $user = app('Dingo\Api\Auth\Auth')->user();
      $payload = $request->only('card_token');
      $token = \Stripe\Token::retrieve($payload['card_token']);
      $customer = \Stripe\Customer::retrieve($user->stripe_cus);
      $customer->source = $token;
      $customer->save();
      return response()->json(['status' => 'You changed your payment method successfully!'], 200);
    }

    public function removepaymentmethod(Request $request)
    {
      if ($request->only('card_token')['card_token'] === null) {
        return response()->json(['error' => 'Please provide a card token!'], 403);
      }
      $user = app('Dingo\Api\Auth\Auth')->user();
      $payload = $request->only('card_token');
      $customer = \Stripe\Customer::retrieve($user->stripe_cus);
      $customer->sources->retrieve($payload['card_token'])->delete();
      return response()->json(['status' => 'You removed a payment method successfully!'], 200);
    }

    public function listpaymentmethod()
    {
      $user = app('Dingo\Api\Auth\Auth')->user();
      $customer = \Stripe\Customer::retrieve($user->stripe_cus);
      $cards = $customer->sources->all(array(
        "object" => "card"
      ));
      return response()->json(['cards' => $cards->data], 200);
    }
}
