<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BrandingTest extends TestCase
{
    use RefreshDatabase;

    private const LOGO = 'images/kunam-logo.jpg';

    public function test_login_page_uses_the_kunam_logo(): void
    {
        $this->get(route('admin.login'))
            ->assertOk()
            ->assertSee(self::LOGO, false)
            ->assertSee('alt="Kunam Birding Tours"', false)
            ->assertDontSee('>BA<', false);
    }

    public function test_admin_layout_uses_the_kunam_logo(): void
    {
        $admin = User::factory()->create();
        $admin->forceFill(['is_admin' => true])->save();

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee(self::LOGO, false)
            ->assertSee('alt="Kunam Birding Tours"', false)
            ->assertDontSee('>BA<', false);
    }
}
