<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){

        $values = $request->validate([
            'name' => 'required|string',
            'email'=> 'required|string|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);

        $user = User::create([
            'name' => $values['name'],
            'email' => $values['email'],
            'password' => bcrypt($values['password'])

        ]);
        
        $token = $user->createtoken('articletoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }
 
    public function login(Request $request){

        $values = $request->validate([
            'email'=> 'required|string',
            'password' => 'required|string'
        ]);

     // Check email
      $user = User::where('email', $values['email'])->first();

      //check password

      if(!$user || !Hash::check($values['password'], $user->password)){
          return response([
              'message' => 'Invaild Credentials'
          ], 401);
      }
        
        $token = $user->createtoken('articletoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }


    public function logout(){
        auth()->user()->tokens()->delete();

        return [

            'message'=> 'Logged Out'
        ]; 

    }
}
