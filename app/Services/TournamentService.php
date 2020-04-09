<?php

namespace App\Services;

use App\Repositories\TournamentRepository;
use App\Repositories\TCategoryGroupsTournamentRepository;
use App\Repositories\TournamentTPaymentMethodRepository;
use Illuminate\Http\Request;

class TournamentService {

	public function __construct(
		TournamentRepository $repository,
		TCategoryGroupsTournamentRepository $tCategoryGroupsTournamentRepository,
		TournamentTPaymentMethodRepository $tournamentTPaymentMethodRepository
		) {
		$this->repository = $repository;
		$this->tCategoryGroupsTournamentRepository = $tCategoryGroupsTournamentRepository;
		$this->tournamentTPaymentMethodRepository = $tournamentTPaymentMethodRepository;
	}

	public function index($perPage) {
		return $this->repository->all($perPage);
	}

	public function getList() {
		return $this->repository->getList();
	}

	public function create($request) {
		if ($this->repository->checkRecord($request['description'])) {
            return response()->json([
                'success' => false,
                'message' => 'Record already exist'
            ])->setStatusCode(400);
        }
		$data = $this->repository->create($request);


		if ($request['payments']) {
			$payments = $request['payments'];
			if(count($payments['itemsToAdd'])) {
				foreach ($payments['itemsToAdd'] as $itemsToAdd) {
					$tournamentPayments = $this->tournamentTPaymentMethodRepository->find($data->id, $itemsToAdd['id']);
					if(!$tournamentPayments) {
						$attr = ['tournament_id' => $data->id, 't_payment_methods_id' => $itemsToAdd['id']];
						$this->tournamentTPaymentMethodRepository->create($attr);
					}
				}
			}
		}


		if ($request['groups']) {
			$groups = $request['groups'];
			if(count($groups['itemsToAdd'])) {
				foreach ($groups['itemsToAdd'] as $itemsToAdd) {
					$categoriesGroup = $this->tCategoryGroupsTournamentRepository->find($data->id, $itemsToAdd['id']);
					if(!$categoriesGroup) {
						$attr = ['tournament_id' => $data->id, 't_categories_groups_id' => $itemsToAdd['id']];
						$this->tCategoryGroupsTournamentRepository->create($attr);
					}
				}
			}
		}
		return $data;
	}

	public function update($request, $id) {
		if ($request['payments']) {
			$payments = $request['payments'];
			if(count($payments['itemsToAdd'])) {
				foreach ($payments['itemsToAdd'] as $itemsToAdd) {
					$tournamentPayments = $this->tournamentTPaymentMethodRepository->find($id, $itemsToAdd['id']);
					if(!$tournamentPayments) {
						$attr = ['tournament_id' => $id, 't_payment_methods_id' => $itemsToAdd['id']];
						$this->tournamentTPaymentMethodRepository->create($attr);
					}
				}
			}

			if(count($payments['itemsToRemove'])) {
				foreach ($payments['itemsToRemove'] as $itemsToRemove) {
					$tournamentPayments = $this->tournamentTPaymentMethodRepository->find($id, $itemsToRemove['id']);
					if($tournamentPayments) {
						$this->tournamentTPaymentMethodRepository->delete($tournamentPayments->id);
					}
				}
			}
		}

		if ($request['groups']) {
			$groups = $request['groups'];
			if(count($groups['itemsToAdd'])) {
				foreach ($groups['itemsToAdd'] as $itemsToAdd) {
					$categoriesGroup = $this->tCategoryGroupsTournamentRepository->find($id, $itemsToAdd['id']);
					if(!$categoriesGroup) {
						$attr = ['tournament_id' => $id, 't_categories_groups_id' => $itemsToAdd['id']];
						$this->tCategoryGroupsTournamentRepository->create($attr);
					}
				}
			}

			if(count($groups['itemsToRemove'])) {
				foreach ($groups['itemsToRemove'] as $itemsToRemove) {
					$categoriesGroup = $this->tCategoryGroupsTournamentRepository->find($id, $itemsToRemove['id']);
					if($categoriesGroup) {
						$this->tCategoryGroupsTournamentRepository->delete($categoriesGroup->id);
					}
				}
			}
		}
      	return $this->repository->update($id, $request);
	}

	public function read($id) {
     return $this->repository->find($id);
	}

	public function delete($id) {
      return $this->repository->delete($id);
	}

	/**
	 *  Search resource from repository
	 * @param  object $queryFilter
	*/
	public function search($queryFilter) {
		return $this->repository->search($queryFilter);
 	}
}