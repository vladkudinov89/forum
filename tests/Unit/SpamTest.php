<?php

namespace Tests\Unit;

use App\Inspections\Spam;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SpamTest extends TestCase
{
    public function test_validates_spam_in_reply()
    {
        $spam = new Spam();

        $this->assertFalse($spam->detected('Test spam text'));

        $this
            ->withoutExceptionHandling()
            ->expectException(\Exception::class);

        $spam->detected('test spam');
    }

    public function test_check_for_any_key_being_held_down()
    {
        $spam = new Spam();

        $this
//            ->withoutExceptionHandling()
            ->expectException(\Exception::class);

        $spam->detected('Hello World aaaaaaaaaa');

    }


}
