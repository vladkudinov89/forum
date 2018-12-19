<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReplyTest extends TestCase
{
    use DatabaseTransactions;

    public function test_is_has_owner()
    {
        $reply = factory('App\Reply')->create();

        $this->assertInstanceOf('App\User' , $reply->owner);
    }
}
