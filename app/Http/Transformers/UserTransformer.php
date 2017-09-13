<?php
namespace App\Http\Transformers;
use App\Http\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform(User $user)
    {
        return [
          'id' => $user->id,
          'first_name' => $user->first_name,
          'last_name' => $user->last_name,
          'gender' => $user->gender,
          'birth_date' => $user->birth_date,
          'email' => $user->email,
          'phone' => $user->phone,
          'profile_image' => env('IMG_URL') . $user->image_id,
        ];
    }

}
