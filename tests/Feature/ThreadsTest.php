<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class ThreadsTest extends TestCase
{
    use DatabaseTransactions;

    public function test_a_user_can_browse_threads()
    {
        $thread = factory('App\Thread')->create();

        $response = $this->get('/threads');
        $response->assertSee($thread->title);
    }

    public function test_a_user_can_browse_current_thread()
    {
        $thread = factory('App\Thread')->create();
        $response = $this->get('/threads/' . $thread->id);
        $response->assertSee($thread->title);
    }


}
