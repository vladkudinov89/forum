<?php

namespace Tests\Feature;

use App\Channel;
use App\Reply;
use App\Thread;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    use DatabaseTransactions;

    public function test_guest_user_can_create_threads()
    {
        $this
            ->withoutExceptionHandling()
            ->expectException(AuthenticationException::class);

        $this->post('/threads', []);
    }

    public function test_guest_cannot_see_create_page()
    {
        $this
            ->assertGuest($guard = null)
            ->get('/threads/create')
            ->assertRedirect('/login');
    }

    public function test_an_authenticated_user_can_create_threads()
    {
        $this->signIn();

        $thread = make(Thread::class);

        $response = $this->post('/threads', $thread->toArray());

        $this->get($response->headers->get('Location'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    public function test_a_thread_requieres_a_title()
    {
        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');
    }

    public function test_a_thread_requieres_a_body()
    {
        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }

    public function test_a_thread_requieres_a_valid_channel_id()
    {
        factory(Channel::class, 2)->create();

        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id' => 999])
            ->assertSessionHasErrors('channel_id');
    }

    public function publishThread($overrides = [])
    {
        $this->signIn();

        $thread = make(Thread::class, $overrides);

        return $this->post('/threads', $thread->toArray());
    }

    public function test_guest_can_delete_test()
    {
        $thread = create(Thread::class);

       $response =  $this
            ->assertGuest($guard = null)
            ->delete($thread->path());

       $response->assertRedirect('/login');

    }

    public function test_a_thread_can_be_deleted()
    {
        $this->signIn();

        $thread = create(Thread::class);

        $reply = create(Reply::class, ['thread_id' => $thread->id]);

        $response = $this->json('DELETE', $thread->path());

        $response->assertStatus(204);

        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
        $this->assertDatabaseHas('channels', ['id' => $thread->channel->id]);
    }
}
