<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HeaderUserMenuTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_header_account_menu_links_to_the_profile_and_logout(): void
    {
        $response = $this->actingAs($this->admin())->get(route('admin.dashboard'));

        $response->assertOk()
            ->assertSee('data-user-menu', false)
            ->assertSee(route('admin.profile.show'), false)
            ->assertSee('Profile')
            ->assertSee('Log out');

        $this->assertSame(2, substr_count($response->getContent(), route('admin.logout')));
    }

    private function admin(): User
    {
        $user = User::factory()->create();
        $user->forceFill(['is_admin' => true])->save();

        return $user;
    }
}
