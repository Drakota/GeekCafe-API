<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Route;
use Illuminate\Http\Request;
use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use Carbon\Carbon;
use App\Http\Models\Promotion;
use App\Http\Transformers\PromotionIndexTransformer;

class PromotionsController extends BaseController
{
    public function index(Request $request)
    {
        $user =  $request->user();
        return $this->transformCollection($user->available_promotions(), new PromotionIndexTransformer);
    }
}
