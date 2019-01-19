<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserAvatarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store()
    {
        $this->validate( request() , [
            'avatar' => ['required' , 'image']
        ]);

        auth()->user()->update([
           'avatar_path' => request()->file('avatar')->store('avatars','public')
        ]);

        if (request()->expectsJson()) {
            return response( [], 204);
        }

        return back();
    }
}
