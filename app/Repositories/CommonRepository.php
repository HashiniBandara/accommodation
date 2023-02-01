<?php


namespace App\Repositories;


use App\Model\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

abstract class CommonRepository
{

    abstract protected function getModelName();

    /**
     * return the filtered result as a page.
     *
     * @param  Request $request
     * @return Collection|static[]
     */
    public function getAllWithSearch($request, $search_columns)
    {

        $query = $this->getModelName()::select("*")
            ->skip($request->start)
            ->take($request->length);

        foreach ($search_columns as $col) {
            if($col && strpos($col,".")!==false){
                $coldata = explode(".", $col);
                $query->orWhereHas($coldata[0], function ($subquery) use ($request, $coldata) {
                    $subquery->orWhere($coldata[1], 'like', '%' . $request->search['value'] . '%');
                });
            }elseif($col){
                $query->orWhere($col, 'like', '%' . $request->search['value'] . '%');
            }
        }

        return $query->orderBy($search_columns[$request->order[0]['column']], $request->order[0]['dir'])
            ->get();
    }
}
