<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegisterConfirmationController extends Controller
{
    public function index()
    {

        $user = User::where('confirmation_token', request('token'))->first();

        if (!$user) {
            return redirect(route('threads'))
                ->with('flash', 'Unknown token');
        }

        $user->confirm();

        return redirect(route('threads'))
            ->with('flash', 'You can post in forum');
    }
}
