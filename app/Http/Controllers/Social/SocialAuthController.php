<?php

namespace App\Http\Controllers\Social;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Mail\PasswordSent;
use Illuminate\Http\Request;
use App\Models\User;
use JWTAuth;
class SocialAuthController extends Controller
{
    
    private function createOrLoginUser($user)
    {
        if(User::where('email',$user->email)->get()->count()==1)
        {
            $user=User::where('email',$user->email)->firstOrFail();
            return JWTAuth::fromUser($user);
        }
        $user=User::create([
            'name'=>$user->name,
            'email'=>$user->email,
            'password'=>Hash::make(Str::random(24)),
        ]);
        return JWTAuth::fromUser($user);

    }
    
    public function github()
    {
        return Socialite::driver('github')->stateless()->redirect();
    } 
    
    public function githubRedirect()
    {
        $user=Socialite::driver('github')->stateless()->user();
        $token=$this->createOrLoginUser($user);
        return response()->json([
            "status"=>0,
            "message"=>"Account created successfully and the password has been sent to your mail id",
            "token"=>$token,
        ]);
    }
}
