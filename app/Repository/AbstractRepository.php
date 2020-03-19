<?php
namespace App\Repository;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

abstract class AbstractRepository
{
    /**
     * @var Model
     */
    private $model;
    /**
     * @var Request
     */
    private $request;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function productFilter($content)
    {

        $this->model = $this->model->where('name', 'like', '%'.$content.'%');
    }

    public function fieldFilter($filter)
    {

        $splitFilter = explode(':',$filter);
        $this->model = $this->model->where ($splitFilter[0], '=', $splitFilter[1]);

    }

    public function sort($field, $direction)
    {
        $this->model = $this->model->orderBy($field, $direction == null? 'ASC':$direction);
    }

    public function getResult()
    {
        return $this->model;
    }
}
