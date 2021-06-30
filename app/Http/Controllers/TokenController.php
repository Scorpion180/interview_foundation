<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use GrahamCampbell\GitHub\Facades\GitHub;

class TokenController extends Controller
{
    public function SaveToken(Request $request){
        $user = User::Find(Auth::user()->id);
        $user->git_token = Crypt::encryptString($request->token);
        $user->save();
        return 'Token saved';
    }
    
    public function GetToken()
    {
        $user = User::Find(Auth::user()->id);
        return Crypt::decryptString($user->git_token);
    }
}
