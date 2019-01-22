<?php
/**
 * Created by PhpStorm.
 * User: vlad
 * Date: 23.01.19
 * Time: 2:26
 */

namespace Tests\Feature;

use App\Thread;
use App\User;
use Tests\TestCase;

class LockThreadTest extends TestCase
{
    public function test_admin_can_lock_any_thread()
    {
        $user = create(User::class , ['confirmed' => 1]);
        $this->signIn($user);

        $thread = create(Thread::class);

        $thread->lock();

        $this->post($thread->path() . '/replies', [
            'body' => 'Foobat',
            'user_id' => auth()->id()
        ])
            ->assertStatus(422);


    }

}
