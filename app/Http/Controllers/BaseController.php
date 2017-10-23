<?php
namespace App\Http\Controllers;
use Illuminate\Routing\Controller;
use Dingo\Api\Routing\Helpers;
use Dingo\Api\Exception\StoreResourceFailedException;
use League\Fractal;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

class BaseController extends Controller
{
    use Helpers;
    protected $fractal;
    function __construct(Manager $fractal) {
        $this->fractal = $fractal;
    }
    public function transformItem($resource, $transformer)
    {
      $constructnotworking = new Manager;
      return $constructnotworking->createData(new Fractal\Resource\Item($resource, $transformer))->toArray();
    }
    public function transformCollection($resource, $transformer)
    {
       return $this->fractal->createData(new Fractal\Resource\Collection($resource, $transformer))->toArray();
    }
    public function paginate($paginator, $transformer)
    {
      $constructnotworking = new Manager;
      $data = $paginator->getCollection();
      $resources = new Collection($data, $transformer);
      $resources->setPaginator(new IlluminatePaginatorAdapter($paginator));
      return $constructnotworking->createData($resources)->toArray();
    }
    public function validation($payload, $rules)
    {
      $validator = app('validator')->make($payload, $rules);
      if ($validator->fails()) {
        throw new StoreResourceFailedException('Could not create new user.', $validator->errors());
      }
    }
}
