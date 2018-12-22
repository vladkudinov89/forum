<?php
namespace Tests\Feature;

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

    public function test_guest_cannot_see_create_page()
    {
        $this->get('/threads/create')
            ->assertRedirect('/login');
    }

    public function test_an_authenticated_user_can_create_threads()
    {
        $this->sigIn();

        $thread = create('App\Thread');

//        $response =
            $this
            ->post('threads', $thread->toArray());
//        $this->assertResponseOk();
//        dd($response->getStatusCode());
//        $this->assertEquals(200, $response->getStatusCode());
//        dd($response->headers->get('Location'));
//        dd($thread->path());
            $this->get($thread->path())
                ->assertSee($thread->title)
                ->assertSee($thread->body);
    }
}
