<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AddAvatarTest extends TestCase
{
    use DatabaseTransactions;

    public function test_only_members_can_add_avatars()
    {
        $this->json('POST' , '/api/users/1/avatar')
            ->assertStatus(401);
    }

    public function test_a_valid_avatar_must_be_provided()
    {
        $this->signIn();

        $this->json('POST' , '/api/users/' . auth()->id() .'/avatar' , [
            'avatar' => 'not-an-image'
        ])
            ->assertStatus(422);
    }

    public function test_a_user_may_add_avatar_to_their_profile()
    {
        $this->signIn();

        Storage::fake('public');

        $this->json('POST' , '/api/users/' . auth()->id() .'/avatar' , [
            'avatar' => $file = UploadedFile::fake()->image('avatar.png')
        ]);

        $this->assertEquals(asset('storage/avatars/' . $file->hashName()) , auth()->user()->avatar_path);

        Storage::disk('public')
        ->assertExists('avatars/' . $file->hashName());
    }


}
