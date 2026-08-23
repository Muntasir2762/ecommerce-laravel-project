<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function registration (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'name' => 'required|string',
            'phone' => 'unique:users,phone'
        ]);

        if($validator->fails()){
            return response()->json([
                'error' => true,
                'message' => 'Validation Error',
                'errors' => $validator->errors(),
            ], 422);
        }

        try{
            $user = new User();

            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password = Hash::make($request->password);
            $user->role = 'customer';

            $user->save();

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'error' => false,
                'message' => 'Registration Successful',
                'user' => $user,
                'token' => $token
            ], 200);


        } catch(\Exception $e){

            return response()->json([
                'error' => true,
                'message' => 'An Error Occured While Registration',
                'user' => [],
                // 'errorMessage' => $e->getMessage()
            ], 500);
        }
    }

    public function login (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        if($validator->fails()){
            return response()->json([
                'error' => true,
                'message' => 'Validation Error',
                'errors' => $validator->errors(),
            ], 422);
        }

        try{
            $user = User::where('email', $request->email)->first();

            if(!$user || !Hash::check($request->password,$user->password)){
                return response()->json([
                    'error' => true,
                    'message' => 'Invalid email or password',
                    'user' => [],
                    'token' => []
                ], 401);
            }

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'error' => false,
                'message' => 'Login Successful',
                'user' => $user,
                'token' => $token
            ], 200);
        } catch(\Exception $e){

            return response()->json([
                'error' => true,
                'message' => 'An Error Occured While Registration',
                'user' => [],
                // 'errorMessage' => $e->getMessage()
            ], 500);
        }
    }

    public function logout (Request $request)
    {
        try{
            $user = $request->user();

            $user->currentAccessToken()->delete();

            return response()->json([
                'error' => false,
                'message' => 'Logout Successful'
            ], 200);

        } catch(\Exception $e){

            return response()->json([
                'error' => true,
                'message' => 'An Error Occured While Registration',
                // 'errorMessage' => $e->getMessage()
            ], 500);
        }
        
    }
}
