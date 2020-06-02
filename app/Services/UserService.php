<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

use App\Role;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\BackOffice\Services\LoginTokenService;


class UserService {

		public function __construct(
			UserRepository $repository,
			LoginTokenService $loginTokenService
			) {
			$this->repository = $repository;
			$this->loginTokenService = $loginTokenService;
		}

		public function index() {
			return $this->repository->all();
		}
		
		public function create($request) {
			return $this->repository->create($request);
		}

		public function update($request, $id) {
			$user = $this->repository->find($id);
			
			if($request['roles'] !== null) {
				$roles = json_decode($request['roles']);
				$user->revokeAllRoles();
				foreach ($roles as $role) {
					$user->assignRole($role);
				}
			}

			return $this->repository->update($id, $request);
		}

		public function registerPassword($request) {
			$user = $this->repository->checkToRegisterPassword($request);
			if(!$user) {
				return response()->json([
					'success' => false,
					'message' => 'Los datos de usuario no coinciden, intente de nuevo'
				])->setStatusCode(400);
			}
			$attr = [ 'password' => bcrypt($request['password'])];
			$data = $this->repository->update($user->id, $attr);
			return response()->json([
                'success' => true,
                'data' => $data
            ]);
		}

		public function read($id) {
						return $this->repository->find($id);
		}

		public function delete($id) {
							return $this->repository->delete($id);
		}

		public function checkUser($user) {
			return $this->repository->checkUser($user);
		}

		public function checkLogin() {
			if (Auth::check()) {
				$token = auth()->user()->createToken('TutsForWeb')->accessToken;
				$user = auth()->user();
				$user->roles = auth()->user()->getRoles();
				return response()->json([
					'success' => true,
					'user' => $user
				]);
			}
			return response()->json([
                'success' => false,
                'message' => 'You must login first'
            ])->setStatusCode(401);
		}

		public function forcedLogin($request) {
			$user =  $this->repository->forcedLogin($request['docId'], $request['token']);
			if($user) {
				$auth = Auth::login($user);
				$token = auth()->user()->createToken('TutsForWeb')->accessToken;
				$user = auth()->user();
				$user->roles = auth()->user()->getRoles();
				return response()->json(['token' => $token, 'user' =>  $user], 200);
			}
		return response()->json([
			'success' => false,
			'message' => 'You must login first'
		])->setStatusCode(401);
		}

		public function search($query) {
			return $this->repository->search($query);
		}
}