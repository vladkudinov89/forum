<?php

namespace Tests\Feature;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    use DatabaseTransactions;

    public function test_can_unauth_user_participate_threads()
    {
        $this
            ->withoutExceptionHandling()
            ->expectException(AuthenticationException::class);

        $this
            ->post('/threads/channel/1/replies', [])
            ->assertRedirect('/login');
    }

    public function test_can_auth_user_participate_threads()
    {
        $user = create('App\User');

        $thread = create('App\Thread');

        $reply = make('App\Reply',
            [
                'thread_id' => $thread->id
            ]
        );

        $this
            ->actingAs($user)
            ->assertAuthenticatedAs($user, $guard = null)
            ->post($thread->path() . '/replies', $reply->toArray());

        $this->get($thread->path())
            ->assertSee($reply->body);

    }
}
  