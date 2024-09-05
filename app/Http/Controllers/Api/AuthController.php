<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models as mods;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email'     => 'required|email',
            'password'  => 'required'
        ]);
    //   $loginData = $request->validate([
    //     'email' => 'required|email',
    //     'password' => 'required',
    //   ]);
      if ($validator->fails()) {
        return response([
            'code' => 422,
            "message" => $validator->errors()
        ]);
        }
      $user = mods\User::where('email', $request->email)->first();

      if(!$user){
        return response([
            'code' => 400,
            'message' => 'Email Not Found !',
        ], 404);
      }

      if(Hash::check($request->password, $user->password)){
        $token = $user->createToken('auth_token')->plainTextToken;
        $response = [
            'code' => 200,
            'user' => $user,
            'token' => $token
        ];

        return response($response, 200);
      }else{
        return response([
            'code' => 400,
            'message' => 'Password not match',
        ], 404);
      }
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            "code" => 200,
            "message" => 'Logout Success',
        ]);
    }
}
