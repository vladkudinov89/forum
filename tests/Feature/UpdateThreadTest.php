<?php
namespace Tests\Feature;

use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UpdateThreadTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp()
    {
        parent::setUp();

        $this->signIn();
    }

    public function test_a_thread_requires_body_and_title_to_be_updated()
    {
        $thread = create(Thread::class, ['user_id' => auth()->id()]);

        $this->patch($thread->path(), [])
            ->assertSessionHasErrors('body')
            ->assertSessionHasErrors('title');
    }


    public function test_a_thread_can_be_updated()
    {
        $thread = create(Thread::class, ['user_id' => auth()->id()]);

        $this->patchJson($thread->path(), [
            'title' => 'Changed',
            'body' => 'Changed body'
        ]);

        $this->assertEquals($thread->fresh()->title, 'Changed');
        $this->assertEquals($thread->fresh()->body, 'Changed body');
    }

    public function test_unautorized_user_cannot_update_thread()
    {
        $thread = create(Thread::class, ['user_id' => create(User::class)->id]);

        $this->patch($thread->path(), [
            'title' => 'Changed'
        ])
            ->assertStatus(403);
    }
}
