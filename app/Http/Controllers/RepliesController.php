<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Support\Facades\Auth;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param $chaneId
     * @param Thread $thread
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store($chaneId, Thread $thread)
    {
        $this->validate(request() , [
            'body' => 'required'
        ]);

        $thread->addReply([
            'body' => request('body'),
            'user_id' => Auth::id()
        ]);

        return back()
            ->with('flash' , 'Your reply has been left.');
    }
}
