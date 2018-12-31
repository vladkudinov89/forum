<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class ProfilesController extends Controller
{
//    public function __construct()
//    {
//        $this->middleware('auth');
//    }


    public function show(User $user)
    {
        return view('profiles.show' , [
            'profileUser' => $user,
            'activites' => $this->getActivity($user)
        ]);
    }

    /**
     * @param User $user
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function getActivity(User $user)
    {
        return $user->activity()->latest()->with('subject')->get()->groupBy(function ($activity) {
            return $activity->created_at->format('Y-m-d');
        });

    }
}
