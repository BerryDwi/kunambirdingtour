<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_the_admin_login(): void
    {
        $this->get(route('admin.profile.show'))
            ->assertRedirect(route('admin.login'));
    }

    public function test_non_admin_users_cannot_view_the_profile(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('admin.profile.show'))
            ->assertForbidden();
    }

    public function test_admin_can_view_their_profile(): void
    {
        $admin = User::factory()->create([
            'name' => 'Birdtour Admin',
            'email' => 'admin@birdtourasia.com',
        ]);
        $admin->forceFill(['is_admin' => true])->save();

        $this->actingAs($admin)
            ->get(route('admin.profile.show'))
            ->assertOk()
            ->assertSee('Birdtour Admin')
            ->assertSee('admin@birdtourasia.com')
            ->assertSee('Administrator');
    }

    public function test_admin_can_update_their_name_and_email(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)
            ->put(route('admin.profile.update'), [
                'name' => 'Updated Admin',
                'email' => 'updated@birdtourasia.com',
            ])
            ->assertRedirect(route('admin.profile.show'))
            ->assertSessionHas('status', 'Profile updated successfully.');

        $this->assertDatabaseHas('users', [
            'id' => $admin->id,
            'name' => 'Updated Admin',
            'email' => 'updated@birdtourasia.com',
        ]);
    }

    public function test_the_profile_email_must_be_unique(): void
    {
        User::factory()->create(['email' => 'taken@birdtourasia.com']);
        $admin = $this->admin();

        $this->actingAs($admin)
            ->from(route('admin.profile.show'))
            ->put(route('admin.profile.update'), [
                'name' => $admin->name,
                'email' => 'taken@birdtourasia.com',
            ])
            ->assertRedirect(route('admin.profile.show'))
            ->assertSessionHasErrors('email');

        $this->assertDatabaseHas('users', [
            'id' => $admin->id,
            'email' => $admin->email,
        ]);
    }

    public function test_admin_can_change_their_password_with_the_current_password(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)
            ->put(route('admin.profile.update'), [
                'name' => $admin->name,
                'email' => $admin->email,
                'current_password' => 'password',
                'password' => 'new-secret-password',
                'password_confirmation' => 'new-secret-password',
            ])
            ->assertRedirect(route('admin.profile.show'));

        $this->assertTrue(Hash::check('new-secret-password', $admin->refresh()->password));
    }

    public function test_the_current_password_must_match_before_changing_it(): void
    {
        $admin = $this->admin();
        $originalHash = $admin->password;

        $this->actingAs($admin)
            ->from(route('admin.profile.show'))
            ->put(route('admin.profile.update'), [
                'name' => $admin->name,
                'email' => $admin->email,
                'current_password' => 'wrong-password',
                'password' => 'new-secret-password',
                'password_confirmation' => 'new-secret-password',
            ])
            ->assertRedirect(route('admin.profile.show'))
            ->assertSessionHasErrors('current_password');

        $this->assertSame($originalHash, $admin->refresh()->password);
    }

    public function test_the_password_can_be_left_unchanged(): void
    {
        $admin = $this->admin();
        $originalHash = $admin->password;

        $this->actingAs($admin)
            ->put(route('admin.profile.update'), [
                'name' => 'Renamed Admin',
                'email' => $admin->email,
                'current_password' => '',
                'password' => '',
                'password_confirmation' => '',
            ])
            ->assertRedirect(route('admin.profile.show'));

        $this->assertSame($originalHash, $admin->refresh()->password);
        $this->assertSame('Renamed Admin', $admin->name);
    }

    public function test_non_admin_users_cannot_update_the_profile(): void
    {
        $this->actingAs(User::factory()->create())
            ->put(route('admin.profile.update'), [
                'name' => 'Nope',
                'email' => 'nope@example.com',
            ])
            ->assertForbidden();
    }

    private function admin(): User
    {
        $user = User::factory()->create();
        $user->forceFill(['is_admin' => true])->save();

        return $user;
    }
}
