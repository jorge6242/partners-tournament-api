<?php

namespace App\Repositories;

use App\Tournament;
use App\TournamentUser;

class TournamentRepository  {
  
    protected $post;

    public function __construct(
      Tournament $model,
      TournamentUser $tournamentUserModel
      ) {
      $this->model = $model;
      $this->tournamentUserModel = $tournamentUserModel;
    }

    public function find($id) {
      $tournament = $this->model->query()->select([
        'id',
        'picture',
        'description',
        'max_participants',
        'description_details',
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
        if($tournament->picture !== null) {
          $tournament->picture = url('tournaments/'.$tournament->picture);
        }
        return $tournament;
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
      $tournaments =  $this->model->query()->select([
          'id',
          'description',
          'picture',
          'max_participants',
          'description_price',
          'description_details',
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
          ])->with(['rules','currency','payments','groups'])->get();
        foreach ($tournaments as $key => $value) {
          if($value->picture !== null) {
            $tournaments[$key]->picture = url('tournaments/'.$value->picture);
          }
        }
        return $tournaments;
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

    public function getByCategory($category) {
      $tournaments =  $this->model->query()->select([
        'id',
        'description',
        'picture',
        'max_participants',
        'description_price',
        'description_details',
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
        ])->with(['rules','currency','payments','groups'])->where('t_categories_id', $category)->get();
      foreach ($tournaments as $key => $value) {
        if($value->picture !== null) {
          $tournaments[$key]->picture = url('tournaments/'.$value->picture);
        }
      }
      return $tournaments;
    }

    public function getInscriptions($queryFilter) {
      $inscriptions = $this->tournamentUserModel->query();
      $inscriptions->with([
        'user' => function($q){
          $q->select('id', 'name', 'last_name', 'doc_id', 'email', 'phone_number');
        },
        'tournament',
        'payment' => function($q){
          $q->select('id', 'description');
        },
        ]);
        if(($queryFilter->query('category') &&  $queryFilter->query('category') > 0) && ($queryFilter->query('tournament') &&  $queryFilter->query('category') > 0)) {
          $inscriptions->where('tournament_id', $queryFilter->query('tournament'));
        } 
        if(($queryFilter->query('category') &&  $queryFilter->query('category') > 0) && ($queryFilter->query('tournament') == 0)) {
          $tournaments = $this->model->where('t_categories_id', $queryFilter->query('category'))->get();
          if(count($tournaments)){
            foreach ($tournaments as $key => $value) {
              $inscriptions->orWhere('tournament_id', $value->id);
            }
          }
        }
        $inscriptions->get();
        foreach ($inscriptions as $key => $value) {
          if($value->attach_file !== null) {
            $inscriptions[$key]->attach_file = url('tournaments/'.$value->attach_file);
          }
        }
        return $inscriptions->paginate($queryFilter->query('perPage'));
      } 

      public function getInscriptionsReport($queryFilter, $isPDF) {
        $inscriptions = $this->tournamentUserModel->query();
        $inscriptions->with([
          'user' => function($q){
            $q->select('id', 'name', 'last_name', 'doc_id', 'email', 'phone_number');
          },
          'tournament',
          'payment' => function($q){
            $q->select('id', 'description');
          },
          ]);

          if($queryFilter->query('status') !== null) {
            $inscriptions->where('status', $queryFilter->query('status'));
          }

          if(($queryFilter->query('category') &&  $queryFilter->query('category') > 0) && ($queryFilter->query('tournament') &&  $queryFilter->query('category') > 0)) {
            $inscriptions->where('tournament_id', $queryFilter->query('tournament'));
          } 
          if(($queryFilter->query('category') &&  $queryFilter->query('category') > 0) && ($queryFilter->query('tournament') == 0)) {
            $tournaments = $this->model->where('t_categories_id', $queryFilter->query('category'))->get();
            if(count($tournaments)){
              foreach ($tournaments as $key => $value) {
                $inscriptions->orWhere('tournament_id', $value->id);
              }
            }
          }

          $inscriptions->get();
            if ($isPDF) {
              return  $inscriptions->get();
            }
          foreach ($inscriptions as $key => $value) {
            if($value->attach_file !== null) {
              $inscriptions[$key]->attach_file = url('tournaments/'.$value->attach_file);
            }
          }
          return $inscriptions->paginate($queryFilter->query('perPage'));
        }  
}