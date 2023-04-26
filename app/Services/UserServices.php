<?php
namespace App\Services;

use App\Http\Requests\LoginUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;

class UserServices{
    use HttpResponses;


    public function register(StoreUserRequest $request){
        $request->validated($request->all());
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return $this->success([
            "user" => $user,
            "token" => $user->createToken('Api Token Of '.$user->name)->plainTextToken
        ]);
    }

    public function login(LoginUserRequest $request){
        $request->validated($request->all());

        if(!Auth::attempt($request->only('email','password'))){
            return $this->error('','Credentials Do Not Match',401);
        };
        $user = User::where('email',$request->email)->first();

        return $this->success([
            'user' => $user,
            'token' => $user->createToken('Api Token Of '.$user->name)->plainTextToken
        ]);
    }

    public function logout(){
        Auth::user()->currentAccessToken()->delete();

        return $this->success([
            "message" => "You Have Successfully Been Logged Out"
        ]);
    }
}