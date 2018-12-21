<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SiteNameTest extends TestCase
{
    public function test_see_site_name_forum()
    {
        $response = $this->get('/threads');

        $response->assertSee('Forum');
    }
}
