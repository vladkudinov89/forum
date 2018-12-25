<?php
namespace Tests\Feature;

use App\Reply;
use App\Thread;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ThreadsMockGetJsonTest extends TestCase
{
    use DatabaseTransactions;

    public function test_a_user_can_filter_thread_by_popularity()
    {
        $threadWithTwoReplies =
            make(Reply::class, ['thread_id' => create(Thread::class)->id], 2);

        $threadWithThreeReplies =
            make(Reply::class, ['thread_id' => create(Thread::class)->id], 3);

        $threadWithNoReplies = make(Reply::class, ['thread_id' => create(Thread::class)->id], 0);

        $threadMock = $this->createMock((Thread::class));
        $threadMock
            ->method('replies')
            ->willReturn(
                array(
                    count($threadWithThreeReplies),
                    count($threadWithTwoReplies),
                    count($threadWithNoReplies)
                )
            );

        $this->assertEquals([3, 2, 0], $threadMock->replies());

    }
}
