<?php

namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\CanResetPassword;
use App\Http\Models\Promotion;
use Carbon\Carbon;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;
use Illuminate\Auth\Passwords\CanResetPassword as CanResetPasswordTrait;
use Illuminate\Notifications\Notifiable as NotifiableTrait;

class User extends Model implements Authenticatable, CanResetPassword
{
    use AuthenticableTrait, CanResetPasswordTrait, NotifiableTrait;
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'gender', 'birth_date', 'phone', 'device_token', 'image_id', 'facebook_id', 'stripe_cus', 'subscription_id'
    ];
    protected $hidden = [
        'password',
    ];
    protected $table = 'users';
    protected $primaryKey = 'id';
    public function sales()
    {
        return $this->hasMany('App\Http\Models\Sale', 'user_id', 'id');
    }
    public function subscription()
    {
        return $this->hasOne('App\Http\Models\Subscription', 'id', 'subscription_id');
    }
    public function used_promotions()
    {
        return $this->hasMany('App\Http\Models\UserPromotion', 'user_id', 'id');
    }
    public function available_promotions()
    {
      $collection = Promotion::where('start_date', '<=', Carbon::today())->where('end_date', '>=', Carbon::today())->get();
      $promotions = $collection->filter(function ($item, $key) {
          if(count($this->used_promotions->where('promotion_id', $item->id)) < $item->available_per_user)
            return true;
          else
            return false;
      });
      return $promotions;
    }
}
