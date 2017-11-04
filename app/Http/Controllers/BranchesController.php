<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Route;
use Illuminate\Http\Request;
use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use Carbon\Carbon;
use App\Http\Models\Branch;
use App\Http\Transformers\BranchIndexTransformer;

class BranchesController extends BaseController
{
    public function index(Request $request)
    {
        $paginator = Branch::paginate(is_numeric($request->input('limit')) ? $request->input('limit') : 10);
        return $this->paginate($paginator, new BranchIndexTransformer);
    }
}
