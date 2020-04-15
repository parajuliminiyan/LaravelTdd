<?php


namespace App\Filters;


use Illuminate\Http\Request;

abstract class Filters
{
    /**
     * @var Request
     */
    protected $request, $builder;
    protected $filters = [];

    /**
     * Filters constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param $builder
     * @return Request
     */
    public function apply($builder)
    {
        $this->builder = $builder;
        //----Functional Approach---------//
//        $this->getFilters()
//            ->filter(function ($filter){
//                return method_exists($this, $filter);
//            })
//            ->each(function ($filter, $value){
//                $this->$filter($value);
//            });
       //---------------------------------//
        foreach ($this->getFilters() as $filter => $value) {
            if (method_exists($this, $filter)) {

                $this->$filter($value);
            }
        }

        return $this->builder;
    }


    protected function getFilters()
    {
//        return collect($this->request->only($this->filters))->flip();
        return $this->request->only($this->filters);
    }
}
