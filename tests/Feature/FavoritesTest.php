<?php

namespace Tests\Feature;


use App\Favorite;
use App\Reply;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class FavoritesTest extends TestCase
{
    use DatabaseTransactions;

    public function test_guest_can_not_favorite_any_reply()
    {
        $this
            ->assertGuest($guard = null)
            ->post('/replies/1/favorites')
            ->assertRedirect('login');
    }

    public function test_an_auth_user_can_favorite_any_reply()
    {
        $this->signIn();

        $reply = create(Reply::class);

        $this->post('replies/' . $reply->id . '/favorites');

        $this->assertCount(1, $reply->favorites);
    }

    public function test_an_auth_user_can_unfavorite_reply()
    {
        $this->signIn();

        $reply = create(Reply::class);

        $this->post('replies/' . $reply->id . '/favorites');

        $this->assertCount(1 , $reply->favorites);

        $this->delete('replies/' . $reply->id . '/favorites');

        $this->assertCount(0, $reply->fresh()->favorites);
    }

    public function test_an_auth_user_can_favorite_only_once_reply()
    {
        $this->signIn();

        $reply = create(Reply::class);

       try {
           $this->post('replies/' . $reply->id . '/favorites');
           $this->post('replies/' . $reply->id . '/favorites');

       } catch (\Exception $e){
           $this->fail('Fail record set twice');
       }

        $this->assertCount(1, $reply->favorites);
    }
}
