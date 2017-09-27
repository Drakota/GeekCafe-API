<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Route;
use Illuminate\Http\Request;
use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use Carbon\Carbon;
use App\Http\Models\Item;
use App\Http\Models\ItemType;
use App\Http\Transformers\ItemTypeTransformer;
use App\Http\Transformers\ItemTransformer;
use App\Http\Transformers\ItemIndexTransformer;

class ItemsController extends BaseController
{
    public function types()
    {
        return $this->transformCollection(ItemType::all(), new ItemTypeTransformer);
    }

    public function index(Request $request)
    {
        if (!$type = ItemType::find($request->input('type'))) {
            return response()->json(['status' => 'Please provide a valid item type!'], 401);
        }
        $paginator = Item::where('type_id', $type->id)->paginate(is_numeric($request->input('limit')) ? $request->input('limit') : 10);
        return $this->paginate($paginator, new ItemIndexTransformer);
    }

    public function view(Item $item)
    {
        return $this->transformItem($item, new ItemTransformer);
    }
}
