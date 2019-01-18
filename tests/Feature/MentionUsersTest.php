<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MentionUsersTest extends TestCase
{
    use DatabaseTransactions;

    public function test_mentioned_users_in_a_reply_are_notified()
    {
        $jonh = create(User::class , ['name' => 'JohnDoe']);

        $this->signIn($jonh);

        $jane = create(User::class , ['name' => 'JaneDoe']);

        $thread = create(Thread::class);

        $reply = make(Reply::class , [
           'body' => '@JaneDoe look at this.'
        ]);

        $this->post($thread->path() . '/replies', $reply->toArray());

        $this->assertCount(1 , $jane->notifications);
    }

    public function test_can_fetch_all_users_mentioned_in_reply_started_given_character()
    {
        create(User::class , ['name' => 'JhnDoe']);
        create(User::class , ['name' => 'JhnDoe2']);
        create(User::class , ['name' => 'JneDoe']);

        $result = $this->json('GET' , 'api/users/' , ['name' => 'jhn']);

        $this->assertCount(2 , $result->json());
    }


}
