<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\User;

class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required|unique:users'
        ]);

        $username = $request->input('username');
        $password = $request->input('password');

        $user = User::where('username', $username)->first();
        if(Hash::check($password, $user->password)){
            $api_token = base64_encode(Str::random(40));
            $user->update([
                'api_token' => $api_token,
            ]);

            return response()->json([
                'status' => 'OK',
                'code' => '201',
                'data' => [
                    'user' => $user,
                    'api_token' => $api_token,
                ]
            ], 201);
        }else{
            return response()->json([
                'status' => 'OK',
                'code' => '400',
                'message' => 'Bad Request'
            ], 400);
        }
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required|unique:users'
        ]);

        $username = $request->input('username');
        $password = Hash::make($request->input('password'));

        $resgist = User::create([
            'username' => $username,
            'password' => $password,
            'balance' => 0,
            'status' => 0,
        ]);

        if($resgist){
            return response()->json([
                'status' => 'OK',
                'code' => '201',
                'data' => $resgist
            ], 201);
        }else{
            return response()->json([
                'status' => 'OK',
                'code' => '400',
                'message' => 'Cannot register new User'
            ], 400);
        }
    }
}
