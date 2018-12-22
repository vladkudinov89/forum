<?php

namespace Tests\Feature;

use App\Thread;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Illuminate\Foundation\Testing\WithoutMiddleware;
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
        $this->sigIn();

        $thread = make(Thread::class);

        $response = $this->post('/threads', $thread->toArray());

        $this->get($response->headers->get('Location'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
