<?php

namespace Tests\Feature;

use App\Thread;
use App\User;
use Tests\TestCase;

class LockThreadTest extends TestCase
{
    public function test_once_lock_thread_can_receive_replies()
    {
        $user = create(User::class, ['confirmed' => 1]);
        $this->signIn($user);

        $thread = create(Thread::class);

        $thread->lock();

        $this->post($thread->path() . '/replies', [
            'body' => 'Foobat',
            'user_id' => auth()->id()
        ])
            ->assertStatus(422);
    }

    public function test_non_admin_may_not_lock_thread()
    {
        $this->signIn(create(User::class , ['isAdmin' => false]));

        $thread = create(Thread::class, ['user_id' => auth()->id()]);

        $this->post(route('locked-threads.store' , $thread))
            ->assertStatus(403);

        $this->assertFalse(!! $thread->fresh()->locked);
    }

    public function test_admin_can_lock_threads()
    {
        $this->signIn(create(User::class , ['isAdmin' => true]));

        $thread = create(Thread::class, ['user_id' => auth()->id()]);

        $this->post(route('locked-threads.store' , $thread));

        $this->assertTrue(!! $thread->fresh()->locked);
    }


}
