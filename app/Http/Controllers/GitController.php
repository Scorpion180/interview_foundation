<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Crypt;
use Github\Client;

class GitController extends Controller
{
    private $client;

    public function __invoke()
    {
        $user = User::Find(Auth::user()->id);
        $this->SeeRepos($user->git_token);
        $this->index();
    }

    public function GetRepos(){
        $user = User::Find(Auth::user()->id);
        $this->SeeRepos(Crypt::decryptString($user->git_token));
        return $this->index();

    }
    public function SeeRepos($token)
    {
        $this->client = new Client();
        $this->client->authenticate($token, null, Client::AUTH_ACCESS_TOKEN);
    }

    public function index()
    {
        try {
            $repos = $this->client->api('current_user')->starring()->all();
            return $this->RepoAsJson($repos);
        } catch (\RuntimeException $e) {
            return $e->message;
        }
    }

    private function RepoAsJson($repos)
    {
        $array = array();
        foreach($repos as $repo){
            array_push($array,array($repo['name'],$repo['html_url']));
        }
        return $array;
    }
}
