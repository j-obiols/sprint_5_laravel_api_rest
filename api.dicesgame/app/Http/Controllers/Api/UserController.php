<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{

    // New user registration
    public function store(Request $request) {

        $validator = Validator::make($request->all(), [ 
            'name'=>'nullable|string|max:255',
            'email'=>'required|string|email|max:255|unique:users',
            'password'=>'required|string|min:8|confirmed'
        ]);
       
        if($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } 

        $validated = $validator->validated();

        $user = User::create([
            'name' => $validated['name']??'Anonymous',
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);

        return response($user, 200);

    }


    // User's login
    public function login(Request $request) {

        $login = $request -> validate([
            'email'=> 'required|string|email',
            'password'=>'required|string'
        ]);

        if(!Auth::attempt($login)) {
            return response (['message'=>'Invalid login credentials.']);
        }
       
         /** @var \App\Models\MyUserModel $user **/
        $user = auth()->user();

        $accessToken = $user->createToken('authToken')->accessToken;

        return response([$user, $accessToken]);

    }


    // Update User's Name
    public function update(Request $request) {
 
        /** @var \App\Models\MyUserModel $user **/
        $user = Auth::User();
        
        $validator = Validator::make($request->all(), [ 
            'name'=>'nullable|string|max:255|regex:/^([^0-9]*)$/'
        ]);
       

        if($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } 
        
        $validated = $validator->validated();


        if($request->name) {
            $user->name = $validated['name'];
        }else{
            $user->name = 'Anonymous';
        }

        $user->save();
        
        return response([$user]);

    }


}
