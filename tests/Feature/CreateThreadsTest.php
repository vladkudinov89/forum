<?php
namespace Tests\Feature;

use App\Thread;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    use DatabaseTransactions;

    public function test_guest_user_ca_create_threads()
    {
        $this
            ->withoutExceptionHandling()
            ->expectException(AuthenticationException::class);

        $this->post('/threads', []);
    }

    public function test_an_authenticated_user_can_create_threads()
    {
        $this->sigIn();

        $thread = create('App\Thread');

        $this->post('/threads', $thread->toArray());

        $thread_add = Thread::where('id', $thread->id)->first();

        $this->get($thread->path())
            ->assertSee($thread->title)
            ->assertSee($thread->body);

        $this->assertEquals($thread->id, $thread_add->id);
    }
}
