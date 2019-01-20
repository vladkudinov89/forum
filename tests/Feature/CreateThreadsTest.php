<?php

namespace Tests\Feature;

use App\Activity;
use App\Channel;
use App\Reply;
use App\Thread;
use Carbon\Carbon;
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

    public function test_auth_user_must_confirm_threir_email_address_before_create_threads()
    {
        $this->publishThread()
            ->assertRedirect('/threads')
            ->assertSessionHas('flash' , 'You must confirm your email address');
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
            ->assertStatus(422);
    }

    public function test_a_thread_requieres_a_body()
    {
        $this->publishThread(['body' => null])
            ->assertStatus(422);
    }

    public function test_a_thread_requieres_a_valid_channel_id()
    {
        factory(Channel::class, 2)->create();

        $this->publishThread(['channel_id' => null])
            ->assertStatus(422);

        $this->publishThread(['channel_id' => 999])
            ->assertStatus(422);
    }

    public function publishThread($overrides = [])
    {
        $this->signIn();

        $thread = make(Thread::class, $overrides);

        return $this->json('post','/threads', $thread->toArray());
    }

    public function test_guest_can_delete_test()
    {
        $this
            ->withoutExceptionHandling()
            ->expectException(AuthenticationException::class);

        $thread = create(Thread::class);

        $response = $this
            ->assertGuest($guard = null)
            ->delete($thread->path());

        $response->assertRedirect('/login');

        $this->signIn();
        $this->delete($thread->path())->assertStatus(403);

    }

    public function test_auth_user_can_be_deleted_a_thread()
    {
        $this->signIn();

        $thread = create(Thread::class, ['user_id' => auth()->id()]);

        $replies = create(Reply::class, ['thread_id' => $thread->id], 3);

        $response = $this->json('DELETE', $thread->path());

        $response->assertStatus(204);

        $this->assertDatabaseMissing('threads', ['id' => $thread->id, 'user_id' => $thread->user_id]);

        foreach ($replies as $reply) {
            $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
        }

        $this->assertDatabaseHas('channels', ['id' => $thread->channel->id]);

        $this->assertEquals(0, Activity::where('user_id', auth()->id())->count());
    }
}
