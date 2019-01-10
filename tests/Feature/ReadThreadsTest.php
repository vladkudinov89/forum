<?php

namespace Tests\Feature;

use App\Channel;
use App\Reply;
use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ReadThreadsTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();

        $this->thread = create('App\Thread');
    }

    public function test_a_user_can_browse_threads()
    {
        $this
            ->get('/threads')
            ->assertSee($this->thread->title);
    }

    public function test_a_user_can_browse_current_thread()
    {
        $this
            ->get($this->thread->path())
            ->assertSee($this->thread->title);
    }

    public function test_user_can_read_thread_replies()
    {
        $reply = create('App\Reply', ['thread_id' => $this->thread->id]);

        $this->assertDatabaseHas('replies' , ['body' => $reply->body]);
    }

    public function test_a_user_can_filter_threads_according_to_a_channel()
    {
        $channel = create(Channel::class);

        $threadInChannel = create(Thread::class, ['channel_id' => $channel->id]);

        $threadNotInChannel = create(Thread::class);

        $this->get('/threads/' . $channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
    }

    public function test_a_user_can_filter_threads_by_username()
    {
        $this->signIn(create(User::class, ['name' => 'JohnDoe']));

        $threadByJohn = create(Thread::class, ['user_id' => auth()->id()]);

        $threadNotByJohn = create(Thread::class);

        $this->get('threads?by=JohnDoe')
            ->assertSee($threadByJohn->title)
            ->assertDontSee($threadNotByJohn->title);
    }

    public function test_can_user_get_all_replies_for_a_given_thread()
    {
        $thread = create(Thread::class);

        create(Reply::class , ['thread_id' =>$thread->id] , 2);

        $response = $this->getJson($thread->path() . '/replies')->json();

        $this->assertCount(2 , $response['data']);
        $this->assertEquals(2 , $response['total']);

    }

    public function test_a_user_can_filter_a_threads_by_those_that_are_unanswered()
    {
        $thread = create(Thread::class);

        create(Reply::class , ['thread_id' => $thread->id]);

        $response = $this->getJson('threads?unanswered=1')->json();

        $this->assertEquals(0 , end($response)['replies_count']);
    }

}
