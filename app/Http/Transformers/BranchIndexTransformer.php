<?php
namespace App\Http\Transformers;
use App\Http\Models\Branch;
use League\Fractal\TransformerAbstract;

class BranchIndexTransformer extends TransformerAbstract
{
    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform(Branch $branch)
    {
        return [
          'id' => $branch->id,
          'location' => $branch->location,
          'coordinates' => $branch->coordinates,
          'email' => $branch->email,
          'phone' => $branch->phone,
          'manager_name' => $branch->manager_name,
          'manager_phone' => $branch->manager_phone,
          'image' => env('IMG_URL') . $branch->image_id,
        ];
    }

}
