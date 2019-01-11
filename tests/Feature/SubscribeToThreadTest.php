<?php
namespace Tests\Feature;

use App\Thread;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class SubscribeToThreadTest extends TestCase
{
    use DatabaseTransactions;

    public function test_a_user_can_subscribe_to_threads()
    {
        $this->signIn();

        $thread = create(Thread::class);

        $this->post($thread->path() . '/subscriptions');

        $this->assertCount(1 , $thread->subscriptions);
    }
}
