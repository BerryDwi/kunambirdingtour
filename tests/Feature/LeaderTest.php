<?php

namespace Tests\Feature;

use Tests\TestCase;

class LeaderTest extends TestCase
{
    public function test_leaders_page_can_be_rendered(): void
    {
        $response = $this->get('/leaders');

        $response->assertStatus(200);
        $response->assertSee('Our Leaders');
        $response->assertSee('James Eaton');
        $response->assertSee('Rob Hutchinson');
        $response->assertSee('Bob Natural');
    }
}
