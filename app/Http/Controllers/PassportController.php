<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use App\Repositories\ShareRepository;

use Illuminate\Http\Request;

class PassportController extends Controller
{
    public function __construct(ShareRepository $shareRepository)
    {
    $this->shareRepository = $shareRepository;
    }
   /**
     * Handles Registration Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $attr = $request->all();
        $checkUser = User::where('doc_id', $request['doc_id'])->first();
        if ($checkUser) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario ya existe'
            ])->setStatusCode(400);
        }
        $attr['confirmation_link'] = md5($request['doc_id'].microtime());
        $user = User::create($attr);
        $role = Role::where('slug', 'participante')->first();
        $user->assignRole($role->id);
        return response()->json(['user' => $user], 200);
    }
 
    /**
     * Handles Login Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {   
        $header = $request->header();
        $header = $header['partners-application'];
        $exist = User::where('username', $request->username)->orWhere('email',$request->username)->first();
        if(!$exist) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no existe'
            ])->setStatusCode(401);
        }
        $credentials = [
            'username' => $exist->username,
            'password' => $request->password
        ];
        
        if ($exist && auth()->attempt($credentials)) {
            $token = auth()->user()->createToken('TutsForWeb')->accessToken;
            $user = auth()->user();
            $user->roles = auth()->user()->getRoles();
            return response()->json(['token' => $token, 'user' =>  $user], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Credenciales incorrectas'
            ])->setStatusCode(401);
        }
    }
 
    /**
     * Returns Authenticated User Details
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function details()
    {
        return response()->json(['user' => auth()->user()], 200);
    }
}
