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

    public function test_knows_if_auth_user_is_subscribe_in_thread()
    {
        $this->signIn();

        $thread = create(Thread::class);

        $this->assertFalse($thread->isSubscribedTo);

        $thread->subscribe();

        $this->assertTrue($thread->isSubscribedTo);
    }

    public function test_a_auth_user_can_delete_subscribed_thread()
    {
        $this->signIn();

        $thread = create(Thread::class);

        $thread->subscribe();

        $this->assertTrue($thread->isSubscribedTo);

        $this->delete($thread->path() . '/subscriptions');

        $this->assertCount(0 , $thread->subscriptions);
    }

    public function test_a_user_can_subscribe_to_threads_and_get_notification()
    {
        $this->signIn();

        $thread = create(Thread::class);

        $this->post($thread->path() . '/subscriptions');

        $this->assertCount(1 , $thread->fresh()->subscriptions);
    }
}
