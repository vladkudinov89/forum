<?php
namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    use DatabaseTransactions;

    protected $thread;

    public function setUp()
    {
        parent::setUp();

        $this->thread = create('App\Thread');
    }

    public function test_a_thread_has_replies()
    {
       $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->thread->replies);
    }

    public function test_thread_has_creator()
    {
        $this->assertInstanceOf('App\User' , $this->thread->creator);
    }

    public function test_a_thread_can_make_a_string_paht()
    {
        $thread = create('App\Thread');

        $this->assertEquals("/threads/{$thread->channel->slug }/{$thread->id}" , $thread->path());
    }

    public function test_a_thread_can_add_reply()
    {
        $this->thread->addReply([
            'body' => 'Foo',
            'user_id' => 1
        ]);

        $this->assertCount(1, $this->thread->replies);
    }

    public function test_a_thread_belong_to_a_channel()
    {
        $thread = create('App\Thread');

        $this->assertInstanceOf('App\Channel' , $thread->channel);
    }
}
