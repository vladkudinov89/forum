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
            ->post('/threads/1/replies', []);
    }

    public function test_can_auth_user_participate_threads()
    {
        $user = factory('App\User')->create();

        $thread = factory('App\Thread')->create();

        $reply = factory('App\Reply')->create([
            'thread_id' => $thread->id
        ]);

        $this
            ->actingAs($user)
            ->assertAuthenticatedAs($user, $guard = null)
            ->post($thread->path() . '/replies', $reply->toArray());

        $this->get($thread->path())
            ->assertSee($reply->body);

    }
}
  