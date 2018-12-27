<?php
/**
 * Created by PhpStorm.
 * User: vlad
 * Date: 27.12.18
 * Time: 16:49
 */

namespace Tests\Feature;


use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use DatabaseTransactions;

    public function test_a_user_have_profile()
    {
        $user = create(User::class);

        $this->get("/profiles/{$user->name}")
            ->assertSee($user->name);
    }

    public function test_profile_display_all_threads_created_by_the_associated_user()
    {
        $user = create(User::class);

        $thread = create(Thread::class, ['user_id' => $user->id]);

        $this->get("/profiles/{$user->name}")
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
