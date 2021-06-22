<?php

namespace App\Http\Controllers\Social;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
class SocialAuthController extends Controller
{
    public function github()
    {
        return Socialite::driver('github')->stateless()->redirect();
    } 

    public function githubRedirect()
    {
        $user=Socialite::driver('github')->stateless()->user();
        $user=User::firstOrCreate([
            'email'=>$user->email
        ],
        [
            'name'=>$user->name,
            'email'=>$user->email,
            'password'=>Hash::make('password123'),

        ]);

        $token=auth()->attempt([ "email"=>$user->email,"password"=>'password123']);

        return response()->json([
            "status"=>0,
            "message"=>"Loggied in",
            "Token"=>$token,
        ]);
    }
}
