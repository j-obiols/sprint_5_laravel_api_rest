<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;


use App\Http\Resources\UserResource;
use App\Http\Resources\UserLogoutResource;
use App\Http\Resources\UserDeleteResource;
Use App\Http\Resources\UserListResource;


class UserController extends Controller{


    public function index() {
    
        /** @var \App\Models\MyUserModel $user **/
        $user = auth()->user();
 
        $users = User::all();
 
        return UserListResource::collection($users);
 
    }


    // New user registration
    public function store(Request $request) {

        $validator = Validator::make($request->all(), [ 
            'name'=>'nullable|string|max:255|regex:/^([^0-9]*)$/',
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
        
        return UserResource::make($user);

    }


    public function login(Request $request) {

        $validator = Validator::make($request->all(), [ 
            'email'=>'required|string|email|max:255',
            'password'=>'required|string|min:8'
        ]);
        
        if($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } 

        $validated = $validator->validated();

        if(!Auth::attempt($validated)) {
            return response()->json (['message'=>'Invalid login credentials.'], 401);
        }
       
        /** @var \App\Models\MyUserModel $user **/
        $user = auth()->user();

        $accessToken = $user->createToken('authToken')->accessToken;

        return response([$user, $accessToken]);

    }


    public function logout(Request $request) {

        /** @var \App\Models\MyUserModel $user **/
        $user = Auth::User();
        $user -> token()->revoke();

        return UserLogoutResource::make($user);

    }

    
    public function show() {
    
        /** @var \App\Models\MyUserModel $user **/
        $user = auth()->user();

        return UserResource::make($user);
    }

    
    public function edit() {
    
        /** @var \App\Models\MyUserModel $user **/
        $user = auth()->user();

        return UserResource::make($user);
    }


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
        
        return UserResource::make($user);

    }


    public function destroy() {

        /** @var \App\Models\MyUserModel $user **/
        $user = Auth::User();

        $user -> delete();
        
        return UserDeleteResource::make($user);

    }


}
