<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller {

   
    public function login(Request $request) {

        $login = $request -> validate([
            'email'=> 'required|string',
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


}
