<?php

namespace Tests\Feature;

use App\Channel;
use App\Reply;
use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
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

        $this->get($this->thread->path())
            ->assertSee($reply->body);
    }

    public function test_a_user_can_filter_threads_according_to_a_channel()
    {
        $channel = create(Channel::class);

        $threadInChannel = create(Thread::class , ['channel_id' => $channel->id]);

        $threadNotInChannel = create(Thread::class);

        $this->get('/threads/' . $channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
    }

    public function test_a_user_can_filter_threads_by_username()
    {
        $this->signIn(create(User::class , ['name' => 'JohnDoe']));

        $threadByJohn = create(Thread::class , ['user_id' => auth()->id()]);

        $threadNotByJohn = create(Thread::class);

        $this->get('threads?by=JohnDoe')
            ->assertSee($threadByJohn->title)
            ->assertDontSee($threadNotByJohn->title);
    }

    public function test_a_user_can_filter_thread_by_popularity()
    {
        $threadWithTwoReplies = create(Thread::class);
        create(Reply::class , ['thread_id' => $threadWithTwoReplies->id] , 2);

        $threadWithThreeReplies = create(Thread::class);
        create(Reply::class , ['thread_id' => $threadWithThreeReplies->id] , 3);

        $threadWithNoReplies = $this->thread;

        $response = $this->getJson('/threads?popular=1')->json();

        $this->assertEquals([3,2,0] , array_column($response , 'replies_count'));

    }

}
