<?php
/**
 * Created by PhpStorm.
 * User: vlad
 * Date: 31.12.18
 * Time: 19:29
 */

namespace Tests\Unit;


use App\Activity;
use App\Reply;
use App\Thread;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ActivityTest extends TestCase
{

    use DatabaseTransactions;

    public function test_it_records_activity_when_thread_is_created()
    {
        $this->signIn();

        $thread = create(Thread::class);

        $this->assertDatabaseHas('activities', [
            'type' => 'created_thread',
            'user_id' => auth()->id(),
            'subject_id' => $thread->id,
            'subject_type' => Thread::class
        ]);

        $activity = Activity::where('user_id' , auth()->id())->first();

        $this->assertEquals($activity->subject->id, $thread->id);
    }

    public function test_it_fetches_a_feed_for_any_user()
    {
        $this->signIn();

        create(Thread::class, ['user_id' => auth()->id()] , 2);

        auth()->user()->activity()->first()->update(['created_at' => Carbon::now()->subWeek()]);

        $feed = Activity::feed(auth()->user());

        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->format('Y-m-d')
        ));

        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->subWeek()->format('Y-m-d')
        ));
    }
}
