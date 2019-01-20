<?php

namespace Tests\Feature;

use App\Mail\PleaseConfirmYourEmail;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use DatabaseTransactions;

    public function test_a_confirmation_email_is_sent_upon_registration()
    {
        Mail::fake();

        $this->post(route('register') , [
            'name' => 'John',
            'email' => 'john@example.com',
            'password' => 'foobar',
            'password_confirmation' => 'foobar',
        ]);

        Mail::assertSent(PleaseConfirmYourEmail::class);
    }

    public function test_user_can_fully_confirm_their_email_addresses()
    {
        $this->post(route('register') , [
           'name' => 'John',
           'email' => 'john@example.com',
           'password' => 'foobar',
           'password_confirmation' => 'foobar',
        ]);

        $user = User::whereName('John')->first();

        $this->assertFalse($user->confirmed);
        $this->assertNotNull($user->confirmation_token);

       $response = $this->get(route('register.confirm' , ['token' => $user->confirmation_token]))
           ->assertRedirect(route('threads'));

        $this->assertTrue($user->fresh()->confirmed);
    }

    public function test_confirming_an_invalid_token()
    {
        $this->get(route('register.confirm' , ['token' => 'invalid']))
            ->assertRedirect(route('threads'))
            ->assertSessionHas('flash' , 'Unknown token');
    }


}
