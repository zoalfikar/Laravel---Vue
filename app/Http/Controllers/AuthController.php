<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name'=>'required|string',
            'email'=>'required|email|string|unique:users,email',
            'password'=>[
                'required',
                'confirmed',
                // Password::min(8)->mixedCase()->numbers()->symbols()
            ]
        ]);

        /** @var App\Models\User $user*/
        $user = User::create([
            'name'=>$data['name'],
            'email'=>$data['email'],
            'password'=>bcrypt($data['password'])

        ]);
        $token = $user->createToken('main')->plainTextToken;
        return response([
            'user'=>$user,
            'token'=>$token
        ]);
    }
    public function login(Request $request)
    {
        $creadintails = $request->validate([
            'email'=>'required|email|string|exists:users,email',
            'password'=> 'required',
            'remember'=>'boolean'
        ]);
        $remember = $creadintails['remember'] ?? false ;
        unset($creadintails['remember']);
        if (!Auth::attempt($creadintails)) {
            return response([
                'errore'=>'Email or Password not exists'
            ],422);
        }

            $user=Auth::user();

            $token = $user->createToken('main')->plainTextToken;
            return response([
                'user'=>$user,
                'token'=>$token
            ]);
    }

    public function logout()
    {
        /** @var User $user */
        $user=Auth::user();
        // remove the token used to authenticate the current request ...
        $user->currentAccessToken()->delete();
        return response([
            'success'=>true
        ]);
    }
}
