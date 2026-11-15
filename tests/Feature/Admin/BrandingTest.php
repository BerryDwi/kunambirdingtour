<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BrandingTest extends TestCase
{
    use RefreshDatabase;

    private const LOGO = '5e8c523028289f697f322d6e_Birdtour-Asia-CMYK-logo.png';

    public function test_login_page_uses_the_birdtour_asia_logo(): void
    {
        $this->get(route('admin.login'))
            ->assertOk()
            ->assertSee(self::LOGO, false)
            ->assertDontSee('>BA<', false);
    }

    public function test_admin_layout_uses_the_birdtour_asia_logo(): void
    {
        $admin = User::factory()->create();
        $admin->forceFill(['is_admin' => true])->save();

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee(self::LOGO, false)
            ->assertDontSee('>BA<', false);
    }
}
