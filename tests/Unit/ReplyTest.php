<?php

namespace Tests\Unit;

use App\Reply;
use App\User;
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
        $reply = create(Reply::class, [
            'body' => '@JaneDoe look at this.@JohnDoe'
        ]);

        $this->assertEquals(['JaneDoe', 'JohnDoe'], $reply->mentionedUsers());
    }

    public function test_wraps_mentioned_username_in_reply_anchor_tags()
    {
        $reply = new Reply(['body' => 'hello @Jone Doe.']);

        $this->assertEquals(
            'hello <a href="/profiles/Jone Doe">@Jone Doe</a>.',
            $reply->body
        );
    }

    public function test_wraps_mentioned_username_in_reply_anchor_tags_without_space()
    {
        $reply = new Reply(['body' => 'hello @Jone.']);

        $this->assertEquals(
            'hello <a href="/profiles/Jone">@Jone</a>.',
            $reply->body
        );
    }

    public function test_it_knows_if_it_best_reply()
    {
        $user = create(User::class, ['confirmed' => true]);
        $this->signIn($user);

        $reply = create(Reply::class);

        $this->assertFalse($reply->isBest());

        $reply->thread->update([
            'best_reply_id' => $reply->id
        ]);

        $this->assertTrue($reply->isBest());
    }


}
