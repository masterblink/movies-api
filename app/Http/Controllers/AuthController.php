<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class AuthController extends Controller
{
    public function signup(Request $request)
    {
        $request->validate([
            'name'       => 'required|string',
            'surname'    => 'required|string',
            'email'      => 'required|string|email|unique:users',
            'birth_date' => 'required|date',
            'password'   => 'required|min:8|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%]).*$/',
        ]);
        $user = new User([
            'name'       => $request->name,
            'surname'    => $request->surname,
            'email'      => $request->email,
            'birth_date' => $request->birth_date,    
            'password'   => bcrypt($request->password),
        ]);
        $user->save();

        return response()->json([
            'message' => 'Usuario creado correctamente!'], 201);
    }
    public function login(Request $request)
    {
        $request->validate([
            'email'       => 'required|string|email',
            'password'    => 'required|string',
            'remember_me' => 'boolean',
        ]);
        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'No tiene autorización'], 401);
        }
        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me) {
            $token->expires_at = Carbon::now()->addWeeks(1);
        }
        $token->save();
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type'   => 'Bearer',
            'expires_at'   => Carbon::parse(
                $tokenResult->token->expires_at)
                    ->toDateTimeString(),
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json(['message' => 
            'Sesión terminada']);
    }

    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}
