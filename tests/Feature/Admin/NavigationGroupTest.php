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
            'Pages',
            'Home Page',
            'Tours Page',
            'Custom Tours Page',
            'Tour Reports Page',
            'Leaders Page',
            'Booking Page',
            'Contact Page',
            'Terms Page',
            'Site',
            'Settings',
            'Inbox',
            'Bookings',
            'Contact Messages',
        ]);
    }

    public function test_pages_group_is_a_dropdown_that_opens_on_the_active_page(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('<summary', false)
            ->assertSee('group/nav mt-5', false)
            ->assertDontSee('group/nav mt-5" open', false);

        $this->actingAs($admin)
            ->get(route('admin.pages.show', 'booking'))
            ->assertOk()
            ->assertSee('group/nav mt-5" open', false);
    }

    private function admin(): User
    {
        $user = User::factory()->create();
        $user->forceFill(['is_admin' => true])->save();

        return $user;
    }
}
