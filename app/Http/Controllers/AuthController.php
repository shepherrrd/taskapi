<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Services\UserServices;
use App\Http\Requests\StoreUserRequest;


class AuthController extends Controller
{
    //
    public function register(UserServices $user, StoreUserRequest $request){
        return $user->register($request);
    }
    public function login(UserServices $user, LoginUserRequest $request){
        return $user->login($request);
    }

    public function logout(UserServices $user){
        return $user->logout();
    }
}
