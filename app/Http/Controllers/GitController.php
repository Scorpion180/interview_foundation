<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
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

    public function SeeRepos($token)
    {
        $this->client = new Client();
        $this->client->authenticate($token, null, Client::AUTH_ACCESS_TOKEN);
    }

    public function index()
    {
        try {
        $repos = $this->client->api('current_user')->starring()->all();
        dd($repos);
        return View::make('idk', ['idk' => $repos]);
        } catch (\RuntimeException $e) {
        $this->handleAPIException($e);
        }
    }
}
