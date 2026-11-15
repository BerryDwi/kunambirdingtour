<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NavigationGroupTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_sidebar_groups_the_navigation(): void
    {
        $response = $this->actingAs($this->admin())->get(route('admin.dashboard'));

        $response->assertOk();
        $response->assertSeeInOrder([
            'Home',
            'Dashboard',
            'Content',
            'Tours',
            'Leaders',
            'Tour Reports',
            'Custom Tours',
            'Terms',
            'Products',
            'Site',
            'Hero Slides',
            'Settings',
            'Inbox',
            'Bookings',
            'Contact Messages',
        ]);
    }

    private function admin(): User
    {
        $user = User::factory()->create();
        $user->forceFill(['is_admin' => true])->save();

        return $user;
    }
}
