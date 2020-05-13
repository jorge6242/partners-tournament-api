<?php

namespace App\Repositories;

use App\TCategory;

class TCategoryRepository  {
  
    protected $post;

    public function __construct(TCategory $model) {
      $this->model = $model;
    }

    public function find($id) {
      $data = $this->model->find($id, ['id', 'description', 'status', 'picture', 't_category_type_id']);
      $data->picture = url('storage/categories/'.$data->picture);
      return $data;
    }

    public function create($attributes) {
      return $this->model->create($attributes);
    }

    public function update($id, array $attributes) {
      return $this->model->find($id)->update($attributes);
    }
  
    public function all($perPage) {
      return $this->model->query()->select(['id', 'description', 'picture', 'status', 't_category_type_id'])->with(['type'])->paginate($perPage);
    }

    public function getList() {
      $categories = $this->model->query()->select(['id', 'description', 'picture'])->with(['type'])->get();
      foreach ($categories as $key => $value) {
        $categories[$key]->picture = url('storage/categories/'.$value->picture);
      }
      return $categories;
    }

    public function delete($id) {
     return $this->model->find($id)->delete();
    }

    public function checkRecord($name)
    {
      $data = $this->model->where('description', $name)->first();
      if ($data) {
        return true;
      }
      return false; 
    }

        /**
     * get banks by query params
     * @param  object $queryFilter
    */
    public function search($queryFilter) {
      $search;
      if($queryFilter->query('term') === null) {
        $search = $this->model->all();  
      } else {
        $search = $this->model->where('description', 'like', '%'.$queryFilter->query('term').'%')->with(['type'])->paginate($queryFilter->query('perPage'));
      }
     return $search;
    }
}