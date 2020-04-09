<?php

namespace App\Http\Controllers;

use App\User;
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
        $user = User::create($attr);
        return response()->json(['$user' => $user], 200);
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
        $credentials = [
            'username' => $request->username,
            'password' => $request->password
        ];
 
        if (auth()->attempt($credentials)) {
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
