<?php

namespace App\Http\Controllers;

use App\Http\Request\CreatePostRequest;
use App\Reply;
use App\Thread;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }

    public function index($channelId, Thread $thread)
    {
        return $thread->replies()->paginate(10);
    }

    /**
     * @param $chaneId
     * @param Thread $thread
     * @param CreatePostRequest $form
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store($chaneId, Thread $thread, CreatePostRequest $form)
    {
        $reply = $thread->addReply([
            'body' => request('body'),
            'user_id' => Auth::id()
        ]);

        return $reply->load('owner');
    }

    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);

        try {
            $this->validate(request(), ['body' => 'required|spamfree']);

            $reply->update(request(['body']));

        } catch (\Exception $e) {
            return response(
                'Sorry,your reply could not be saved', 422
            );
        }
    }

    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->delete();

        if (request()->expectsJson()) {
            return response(['status' => 'Reply Deleted.']);
        }

        return back();
    }
}
