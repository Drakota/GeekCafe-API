<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Route;
use Illuminate\Http\Request;
use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Http\Response;
use Carbon\Carbon;
use App\Http\Models\Subscription;

class SubscriptionsController extends BaseController
{
    public function index(Request $request)
    {
        return Subscription::all()->makeHidden(['created_at', 'updated_at']);
    }
}
