<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Models\Image as ImageTable;
use Dingo\Api\Exception\StoreResourceFailedException;
use Intervention\Image\ImageManagerStatic as Image;

class UploadsController extends BaseController
{
     public function upload()
     {
       $user = $this->auth->user();
       $rules = [
         'image' => ['required'],
       ];
       $payload = app('request')->only('image');
       $validator = app('validator')->make($payload, $rules);
       if ($validator->fails()) {
           throw new StoreResourceFailedException('Could not upload this image.', $validator->errors());
       }
       if (base64_encode(base64_decode($payload['image'], false)) !== $payload['image']) {
         return response()->json(['success' => false, 'status' => "The provided image is not in a valid base64 format!"], 403);
       }
       Image::make($payload['image']);
       $upload = ImageTable::create([
          'id' => bin2hex(openssl_random_pseudo_bytes(7)),
          'image' => $payload['image'],
       ]);
       return response()->json(['success' => true, 'status' => "Image uploaded successfuly!", 'image_id' => $upload->id], 200);
     }
}
