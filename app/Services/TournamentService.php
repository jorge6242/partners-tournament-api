<?php

namespace App\Services;

use App\TournamentUser;
use App\Repositories\TournamentRepository;
use App\Repositories\TCategoryGroupsTournamentRepository;
use App\Repositories\TournamentTPaymentMethodRepository;
use Illuminate\Http\Request;

use Storage;
use Carbon\Carbon;

class TournamentService {

	public function __construct(
		TournamentRepository $repository,
		TCategoryGroupsTournamentRepository $tCategoryGroupsTournamentRepository,
		TournamentTPaymentMethodRepository $tournamentTPaymentMethodRepository,
		TournamentUser $tournamentUserModel
		) {
		$this->repository = $repository;
		$this->tCategoryGroupsTournamentRepository = $tCategoryGroupsTournamentRepository;
		$this->tournamentTPaymentMethodRepository = $tournamentTPaymentMethodRepository;
		$this->tournamentUserModel = $tournamentUserModel;
	}

	public function index($perPage) {
		return $this->repository->all($perPage);
	}

	public function getList() {
		return $this->repository->getList();
	}

	public function validateFile($file) {

		$fileToParse = preg_replace('/^data:application\/\w+;base64,/', '', $file);
		$ext = explode(';', $file)[0];
		$ext = explode('/', $ext)[1];

		$find = 'data:application/vnd.openxmlformats-officedocument.wordprocessingml.document;base64,';
		$pos = strpos($file, $find);
		if($pos !== false) {
			$fileToParse = str_replace('data:application/vnd.openxmlformats-officedocument.wordprocessingml.document;base64,', '', $file);
			$ext = 'docx';
		}
		$base64File = base64_decode($fileToParse);
		
		return (object)['ext' => $ext, 'content' => $base64File];
	}

	public function create($request) {
		Storage::disk('tournaments')->put('testfile.txt','ContentTest');
		$image = '';
		if ($this->repository->checkRecord($request['description'])) {
            return response()->json([
                'success' => false,
                'message' => 'Evento ya existe'
            ])->setStatusCode(400);
		}
		if($request['picture'] !== null) {
				\Image::make($request['picture'])->save(public_path('storage/tournaments/').$request['description'].'.png');
				$request['picture'] = $request['description'].'.png';
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
		Storage::disk('tournaments')->put('testfile.txt','ContentTest');
		$image = $request['picture'];
		if (substr($image, 0, 4) === "http" ) {
			$request['picture'] = $request['description'].'.png';
		} else {
			if($image !== null) {
				\Image::make($request['picture'])->save(public_path('storage/tournaments/').$request['description'].'.png');
				$request['picture'] = $request['description'].'.png';
			} else {
				$request['picture'] = "empty.png";
			}
		}
      	return $this->repository->update($id, $request);
	}

	public function read($id) {
     return $this->repository->find($id);
	}

	public function delete($id) {
		$tournamenUser = $this->tournamentUserModel->where('tournament_id',$id)->first();
		if($tournamenUser) {
			return response()->json([
                'success' => false,
                'message' => 'El Evento no puede eliminarse porque tiene inscriptiones asociadas'
            ])->setStatusCode(400);
		}
		$data = $this->repository->delete($id);
		return response()->json([
			'success' => true,
			'data' => $data
		  ]);
	}

	/**
	 *  Search resource from repository
	 * @param  object $queryFilter
	*/
	public function search($queryFilter) {
		return $this->repository->search($queryFilter);
	 }


	/**
	 *  Search resource from repository
	 * @param  object $queryFilter
	*/
	public function searchInscriptions($queryFilter) {
		return $this->repository->searchInscriptions($queryFilter);
	 }


	public function getTokenString($length){
		$token = "";
		$codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
		$codeAlphabet.= "0123456789";
		$max = strlen($codeAlphabet); // edited
		
		for ($i=0; $i < $length; $i++) {
			$token .= $codeAlphabet[random_int(0, $max-1)];
		}
		return $token;
	}
	 
	 public function storeParticipant($request) {
		$date = Carbon::now();
		$user = auth()->user();

		// Validacion si el participante existe en el evento
		$isValid = $this->tournamentUserModel->query()
			->where('user_id', $user->id)
			->where('tournament_id', $request['tournament_id'] )
			->with(['tournament'])
			->first();
		if($isValid) {
			$tournament = $isValid->tournament()->first();
			return response()->json([
				'success' => false,
				'message' => 'Participante ya esta registrado en el Evento : '.$tournament->description.''
			])->setStatusCode(400);
		}

		//Validacion de maximo de participantes
		$participants = $this->tournamentUserModel->where('tournament_id', $request['tournament_id'])->where('status','!=',"-1")->count();
		$currentTournament = $this->repository->find($request['tournament_id']);
		if($currentTournament->booking_type == 1 && $participants >= (float)$currentTournament->max_participants) {
			return response()->json([
				'success' => false,
				'message' => 'El cupo maximo de participantes se ha excedido <br> Intente nuevamente mas tarde para verificar si se libera algun cupo y se puede inscribir nuevamente.'
			])->setStatusCode(400);
		}

		$request['register_date'] = $date;
		$request['locator'] = $this->getTokenString(10);
		$request['confirmation_link'] = md5($user->doc_id.$date.microtime());
		$data = $this->tournamentUserModel->create($request);
		if($request['attachFile'] !== null) {
			$parseFile = $this->validateFile($request['attachFile']);
			$filename = $data->id.'-invoice-'.$date->year.'.'.$parseFile->ext;
			if($parseFile->ext === 'png' || $parseFile->ext === 'jpg' || $parseFile->ext === 'jpeg' ) {
				if($parseFile->ext === 'jpg' || $parseFile->ext === 'jpeg') {
					$filename = $data->id.'-invoice-'.$date->year.'.png';
				}
				\Image::make($request['attachFile'])->save(public_path('storage/tournamentFiles/').$filename);
			} else {
				Storage::disk('tournamentFiles')->put($filename,$parseFile->content);
			}	
			$attr = [ 'attach_file' => $filename];
			$this->tournamentUserModel->find($data->id)->update($attr);
		}
		return $data;
	 }

	 public function getByCategory($id) {
		return $this->repository->getByCategory($id);
	  }

	  public function getAvailableTournamentsByCategory($id) {
		return $this->repository->getAvailableTournamentsByCategory($id);
	  }

	  public function getAvailableTournament($id) {
		return $this->repository->getAvailableTournament($id);
	  }

	  public function getInscriptions($queryFilter) {
		return $this->repository->getInscriptions($queryFilter);
	  }

	  public function getInscriptionsByParticipant($queryFilter) {
		return $this->repository->getInscriptionsByParticipant($queryFilter);
	  }

	  	  public function getInscriptionsReport($queryFilter, $isPdf = false) {
		return $this->repository->getInscriptionsReport($queryFilter, $isPdf);
	  }

	  public function getParticipant($id){
		return $this->tournamentUserModel->find($id);
	  }

	  public function updateParticipant($request){
		return $this->tournamentUserModel->find($request['id'])->update($request);
	  }

	  public function updateParticipantPayment($request){
		$request['fec_pago'] = Carbon::now();
		return $this->tournamentUserModel->find($request['id'])->update($request);
	  }

	  public function getAvailablePlayerTournament($id) {
		return $this->repository->getAvailablePlayerTournament($id);
	  }

	  public function getAvailableQuota($id) {
		return $this->repository->getAvailableQuota($id);
	  }
}