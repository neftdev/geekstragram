<?php

namespace App\Http\Controllers\Api;

use Validator;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public $codeError = 400;
    public $codeSuccess = 200;

    public function register(Request $request) {
        // La contraseña debe contener algunos caracteres de al menos tres de las siguientes cinco categorías:
        // Caracteres en mayúscula (A - Z)
        // Caracteres en minúscula (a - z)
        // Numero (0 - 9)
        // No alfanumérico (por ejemplo:!, $, # O%)
        // Caracteres Unicode
        // 'password' => 'required|min:6|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%]).*$/',
        $validator = Validator::make($request->all(), [
            'user_name' => 'required|unique:users,user_name',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], $this->codeError);
        }

        $data = $validator->validate();
        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);
        return response()->json([
            'message' => 'Usuario creado con exito',
            'email' => $user->email
        ], $this->codeSuccess);
    }

    public function login(Request $request) {
        $request->validate([
            'email'       => 'required|string|email',
            'password'    => 'required|string'
        ]);

        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
        $user = $request->user();
        return response()->json([
            'email' => $user->email
        ]);
    }

}
