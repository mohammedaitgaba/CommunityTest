<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request){
        //validator
        $validator = Validator::make($request->all(),[
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if($validator->fails()){
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];
            return response()->json($response, 400);
        }
        $input = $request->all();

        $email = User::where('email',$input['email'])->first();
        if($email){
            return response()->json(['message' => 'Email Already exist'], 401);
        }

        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        $response = [
            'success' => true,
            'message' => "user register succefully"
        ];

        return response()->json($response, 200);
        
    }
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $accessToken = $user->createToken('authToken')->plainTextToken;
            return response()->json(['access_token' => $accessToken,'id'=>$user->id]);
        }else{
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    }
}
