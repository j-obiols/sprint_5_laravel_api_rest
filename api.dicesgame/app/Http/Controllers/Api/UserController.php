<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\GeneralJsonException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;


use App\Http\Resources\UserResource;
use App\Http\Resources\UserLogoutResource;
use App\Http\Resources\UserDeleteResource;
use App\Http\Resources\UserListResource;


class UserController extends Controller{


    public function index() {
    
        /** @var \App\Models\MyUserModel $user **/
        $user = auth()->user();
 
        $users = User::all();

        if(!$users){
            throw new GeneralJsonException(message: 'Something went wrong. Please try again', code: 404);
        }
 
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
            'password' => bcrypt($validated['password']),
        ]);

        
        if(!$user){
            throw new GeneralJsonException(message: 'Something went wrong. Please try again', code: 404);
        }

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
        $user = Auth::User();

        $accessToken = $user->createToken('authToken')->accessToken;

        if(!$accessToken){
            throw new GeneralJsonException(message: 'Something went wrong. Please try again', code: 404);
        }

        return response()->json(['data' =>['name'=>$user->name, 'email'=>$user->email, 'token'=>$accessToken]]);

    }


    public function logout(Request $request) {

        /** @var \App\Models\MyUserModel $user **/
        $user = Auth::User();

        $user -> token()->revoke();

        return UserLogoutResource::make($user);

    }

    
    public function show($id) {
    
        /** @var \App\Models\MyUserModel $user **/
        $user = Auth::User();

        if ($id != $user->id) {
            throw new GeneralJsonException(message: 'Unauthorized', code: 401);
        }  
        
        return UserResource::make($user);
    }

    
    public function edit($id) {
    
        /** @var \App\Models\MyUserModel $user **/
        $user = Auth::User();

        if ($id != $user->id) {
            throw new GeneralJsonException(message: 'Unauthorized', code: 401);
        }  

        return UserResource::make($user);
    }


    public function update(Request $request, $id) {
 
        /** @var \App\Models\MyUserModel $user **/
        $user = Auth::User();
       
        if ($id != $user->id) {
            throw new GeneralJsonException(message: 'Unauthorized.', code: 401);
        }  
        
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


    public function destroy($id) {

        /** @var \App\Models\MyUserModel $user **/
        $user = Auth::User();

        if ($id != $user->id) {
            throw new GeneralJsonException(message: 'Unauthorized', code: 401);
        }  

        $user -> delete();
        
        return UserDeleteResource::make($user);

    }


}
