<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
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
        $this->signIn();

        $thread = create('App\Thread');

        $reply = make('App\Reply',
            [
                'thread_id' => $thread->id
            ]
        );

        $this->post($thread->path() . '/replies', $reply->toArray());

        $this->assertDatabaseHas('replies', ['body' => $reply->body]);

        $this->assertEquals(1, $thread->fresh()->replies_count);

    }

    public function test_a_reply_required_body()
    {
        $this->signIn();

        $thread = create(Thread::class);

        $reply = make(Reply::class, ['body' => null]);

        $this->json('post',$thread->path() . '/replies', $reply->toArray())
            ->assertStatus(422);
    }

    public function test_unauthorized_users_cannot_delete_replies()
    {
        $reply = create(Reply::class);

        $this->delete("/replies/{$reply->id}")
            ->assertRedirect('login');

        $this->signIn()
            ->delete("/replies/{$reply->id}")
            ->assertStatus(403);
    }

    public function test_authorized_users_can_delete_replies()
    {
        $this->signIn();

        $reply = create(Reply::class, ['user_id' => auth()->id()]);

        $this->delete("/replies/{$reply->id}")
            ->assertStatus(302);

        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);

        $this->assertEquals(0, $reply->thread->fresh()->replies_count);
    }

    public function test_auth_user_can_update_replies()
    {
        $this->signIn();

        $reply = create(Reply::class, ['user_id' => auth()->id()]);

        $str = 'You been changed, fool.';

        $this->patch('/replies/' . $reply->id, ['body' => $str]);

        $this->assertDatabaseHas('replies', ['id' => $reply->id, 'body' => $str]);
    }

    public function test_unauthorized_users_cannot_update_replies()
    {
        $reply = create(Reply::class);

        $this->patch("/replies/{$reply->id}")
            ->assertRedirect('login');

        $this->signIn()
            ->patch("/replies/{$reply->id}")
            ->assertStatus(403);
    }

    public function test_replies_that_contain_spam_not_be_created()
    {
        $this->signIn();

        $thread = create(Thread::class);

        $reply = make(Reply::class, ['body' => 'test spam']);

        $this->json('post',$thread->path() . '/replies', $reply->toArray())
        ->assertStatus(422);

    }

    public function test_a_user_can_add_reply_once_per_minute()
    {
        $this->signIn();

        $thread = create(Thread::class);

        $reply = make(Reply::class, ['body' => 'Simply reply']);

        $this->post($thread->path() . '/replies', $reply->toArray())
            ->assertStatus(201);

        $this->post($thread->path() . '/replies', $reply->toArray())
            ->assertStatus(429);

    }


}
  