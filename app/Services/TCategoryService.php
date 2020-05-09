<?php

namespace App\Services;

use App\Repositories\TCategoryRepository;
use Illuminate\Http\Request;

use Storage;

class TCategoryService {

	public function __construct(TCategoryRepository $repository) {
		$this->repository = $repository ;
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
                'message' => 'Registro ya existe'
            ])->setStatusCode(400);
		}
		Storage::disk('categories')->put('testfile.txt','ContentTest');
		$image = $request['picture'];
		if($image !== null) {
			\Image::make($request['picture'])->save(public_path('storage/categories/').$request['description'].'.png');
			$request['picture'] = $request['description'].'.png';
		} else {
			$request['picture'] = "empty.png";
		}
		return $this->repository->create($request);
	}

	public function update($request, $id) {
		Storage::disk('categories')->put('testfile.txt','ContentTest');
		$image = $request['picture'];
		if (substr($image, 0, 4) === "http" ) {
			$request['picture'] = $request['description'].'.png';
		} else {
			if($image !== null) {
				\Image::make($request['picture'])->save(public_path('storage/categories/').$request['description'].'.png');
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