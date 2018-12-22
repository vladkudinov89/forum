<?php

namespace Tests\Unit;

use App\Channel;
use App\Thread;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChannelTest extends TestCase
{
    public function test_a_channel_consist_threads()
    {
        $channel = create(Channel::class);

        $thread = create(Thread::class , ['channel_id' => $channel->id]);

        $this->assertTrue($channel->threads->contains($thread));

    }
}
