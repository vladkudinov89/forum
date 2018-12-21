<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class ThreadsTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();

        $this->thread = factory('App\Thread')->create();
    }

    public function test_a_user_can_browse_threads()
    {
        $response = $this->get('/threads');
        $response->assertSee($this->thread->title);
    }

    public function test_a_user_can_browse_current_thread()
    {
        $response = $this->get($this->thread->path());
        $response->assertSee($this->thread->title);
    }

    public function test_user_can_read_thread_replies()
    {
        $reply = factory('App\Reply')->create(['thread_id' => $this->thread->id]);

        $this->get($this->thread->path())
            ->assertSee($reply->body);
    }


}
