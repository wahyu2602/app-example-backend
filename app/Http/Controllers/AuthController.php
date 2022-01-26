<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
  public function Register(Request $request)
  {
    $validate = $request->validate([
      'name' => 'required',
      'email' => 'required|email|unique:users',
      'password' => 'required|confirmed|min:6'
    ]);

    $user = User::create([
      'name' => $validate['name'],
      'email' => $validate['email'],
      'password' => bcrypt($validate['password'])
    ]);

    return response()->json(['data' => $user], Response::HTTP_CREATED);
  }

  public function Login(Request $request)
  {
    $credentials = $request->validate([
      'email' => 'required|email',
      'password' => 'required'
    ]);

    if (Auth::attempt($credentials)) {
      $token = $request->user()->createToken($credentials['email']);

      return response()->json([
        'massage' => 'Login success!',
        'token' => $token->plainTextToken
      ], Response::HTTP_OK);
    }

    return response()->json(['massage' => 'email or password do not match our records.']);
  }

  public function Logout(Request $request)
  {
    $request->user()->tokens()->delete();

    return response()->json(['massage' => 'Your logout success!'], Response::HTTP_OK);
  }
}
