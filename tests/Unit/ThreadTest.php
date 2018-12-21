<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadTest extends TestCase
{
    use DatabaseTransactions;

    protected $thread;

    public function setUp()
    {
        parent::setUp();

        $this->thread = factory('App\Thread')->create();
    }

    public function test_a_thread_has_replies()
    {
       $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->thread->replies);
    }

    public function test_thread_has_creator()
    {
        $this->assertInstanceOf('App\User' , $this->thread->creator);
    }

    public function test_a_thread_can_add_reply()
    {
        $this->thread->addReply([
            'body' => 'Foo',
            'user_id' => 1
        ]);

        $this->assertCount(1, $this->thread->replies);
    }
}
