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
        $paginator = Promotion::where('start_date', '<=', Carbon::today())
        ->where('end_date', '>=', Carbon::today())
        ->paginate(is_numeric($request->input('limit')) ? $request->input('limit') : 10);
        return $this->paginate($paginator, new PromotionIndexTransformer);
    }
}
