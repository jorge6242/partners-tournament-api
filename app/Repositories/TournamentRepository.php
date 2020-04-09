<?php

namespace App\Repositories;

use App\Tournament;

class TournamentRepository  {
  
    protected $post;

    public function __construct(Tournament $model) {
      $this->model = $model;
    }

    public function find($id) {
      return $this->model->query()->select([
        'id',
        'description',
        'max_participants',
        'description_price',
        'template_welcome_mail',
        'template_confirmation_mail',
        'amount',
        'participant_type',
        'date_register_from',
        'date_register_to',
        'date_from',
        'date_to',
        't_rule_type_id',
        'currency_id',
        't_categories_id',
        't_category_types_id',
        ])->where('id', $id)->with(['payments', 'groups'])->first();
    }

    public function create($attributes) {
      return $this->model->create($attributes);
    }

    public function update($id, array $attributes) {
      return $this->model->find($id)->update($attributes);
    }
  
    public function all($perPage) {
      return $this->model->query()->select([
          'id',
          'description',
          'max_participants',
          'description_price',
          'template_welcome_mail',
          'template_confirmation_mail',
          'amount',
          'participant_type',
          'date_register_from',
          'date_register_to',
          'date_from',
          'date_to',
          't_rule_type_id',
          'currency_id',
          't_categories_id',
          't_category_types_id',
          ])->paginate($perPage);
    }

    public function getList() {
      return $this->model->query()->select([
          'id',
          'description',
          'max_participants',
          'description_price',
          'template_welcome_mail',
          'template_confirmation_mail',
          'amount',
          'participant_type',
          'date_register_from',
          'date_register_to',
          'date_from',
          'date_to',
          't_rule_type_id',
          'currency_id',
          't_categories_id',
          't_category_types_id',
          ])->get();
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
        $search = $this->model->where('description', 'like', '%'.$queryFilter->query('term').'%')->paginate($queryFilter->query('perPage'));
      }
     return $search;
    }
}