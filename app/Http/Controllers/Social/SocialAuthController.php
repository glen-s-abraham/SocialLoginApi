<?php

namespace App\Http\Controllers\Social;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Mail\PasswordSent;
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

        if(User::where('email',$user->email)->get()->count()==1)
        {
            return response()->json([
            "status"=>0,
            "message"=>"Account Already created",
        ]);
        }

        $password=Str::random(24);
        $user=User::firstOrCreate([
            'email'=>$user->email
        ],
        [
            'name'=>$user->name,
            'email'=>$user->email,
            'password'=>Hash::make($password),

        ]);

        Mail::to($user)->send(new PasswordSent($password));

        return response()->json([
            "status"=>0,
            "message"=>"Account created successfully and the password has been sent to your mail id",
        ]);
    }
}
