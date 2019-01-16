<?php

namespace Tests\Unit;

use App\Reply;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ReplyTest extends TestCase
{
    use DatabaseTransactions;

    public function test_knows_if_it_just_published()
    {
        $reply = create(Reply::class);

        $this->assertTrue($reply->wasJustPublished());

        $reply->created_at = Carbon::now()->subMonth();

        $this->assertFalse($reply->wasJustPublished());
    }

    public function test_can_detected_all_mentioned_users_in_body()
    {
        $reply = create(Reply::class , [
           'body' => '@JaneDoe look at this.@JohnDoe'
        ]);

        $this->assertEquals(['JaneDoe' , 'JohnDoe'] , $reply->mentionedUsers());
    }


}
