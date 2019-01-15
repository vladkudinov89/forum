<?php

namespace Tests\Unit;


use App\Reply;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    public function test_a_user_can_fetch_threir_most_recent_reply()
    {
        $user = create(User::class);

        $reply = create(Reply::class , ['user_id' => $user->id]);

        $this->assertEquals($reply->id , $user->lastReply->id);
    }

}
