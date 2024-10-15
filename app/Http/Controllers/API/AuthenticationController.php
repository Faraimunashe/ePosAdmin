<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\CurrencyRate;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Validator;

class AuthenticationController extends Controller
{
    public function register(Request $request)
    {
        $rules = [
            'name' => ['required', 'string'],
            'email' => ['required', 'string', 'unique:users,email'],
            'password' => ['required', 'string', 'confirmed']
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails())
        {
            $errors = $validator->errors();
            $response = [
                'message' => 'Validation error',
                'errors' => $errors->all()
            ];

            return response()->json($response, 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        //$token = $user->createToken('equilibtoken')->plainTextToken;

        $response = [
            'message' => 'Successfully added new user',
            'user' => $user,
            //'token' => $token
        ];

        return response()->json($response, 200);
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();

        $response = [
            'message' => 'logged out'
        ];

        return response()->json($response, 200);
    }


    public function login(Request $request)
    {
        $rules = [
            'email' => ['required', 'email'],
            'password' => ['required', 'string']
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails())
        {
            $errors = $validator->errors();
            $response = [
                'message' => 'Validation error',
                'errors' => $errors->all()
            ];

            return response()->json($response, 400);
        }

        $user = User::where('email', $request->email)->first();
        $rates = CurrencyRate::all();

        if (is_null($user) || !Hash::check($request->password, $user->password))
        {
            return response()->json([
                'message' => 'Wrong credentials'
            ], 401);
        }

        $token = $user->createToken('ePOStoken')->plainTextToken;

        $response = [
            'message' => 'Successfully logged in',
            'user' => $user,
            'token' => $token,
            'rates' => $rates
        ];

        return response()->json($response, 200);
    }
}
