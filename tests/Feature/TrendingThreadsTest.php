<?php
namespace Tests\Feature;

use App\Thread;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Redis;
use Tests\TestCase;

class TrendingThreadsTest extends TestCase
{
    use DatabaseTransactions;

    public function test_it_increments_a_threads_score_each_time_it_read()
    {
        $this->assertEmpty(Redis::zrevrange('trending_threads' , 0 , -1));

        $thread = create(Thread::class);

        $this->call('GET' , $thread->path());


    }

}
