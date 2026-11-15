<?php

namespace Tests\Feature\Admin;

use App\Models\TermsSection;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TermsSectionManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_admin_users_cannot_access_terms_sections(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('admin.terms-sections.index'))
            ->assertForbidden();
    }

    public function test_admin_can_see_the_terms_listing(): void
    {
        TermsSection::factory()->create(['number' => 4, 'title' => 'Deposits']);

        $this->actingAs($this->admin())
            ->get(route('admin.terms-sections.index'))
            ->assertOk()
            ->assertSee('Deposits')
            ->assertSee('4');
    }

    public function test_admin_can_create_a_terms_section(): void
    {
        $this->actingAs($this->admin())
            ->post(route('admin.terms-sections.store'), [
                'number' => 5,
                'title' => 'Cancellation policy',
                'nav_title' => 'Cancellations',
                'body' => 'Cancellations must be made in writing.',
            ])
            ->assertRedirect(route('admin.terms-sections.index'));

        $section = TermsSection::query()->where('title', 'Cancellation policy')->firstOrFail();

        $this->assertSame(5, $section->number);
        $this->assertSame(5, $section->sort_order);
        $this->assertSame('Cancellations', $section->navTitle());
    }

    public function test_sort_order_defaults_to_the_section_number(): void
    {
        $this->actingAs($this->admin())
            ->post(route('admin.terms-sections.store'), [
                'number' => 8,
                'title' => 'Insurance',
                'body' => 'Travel insurance is mandatory.',
            ])
            ->assertRedirect(route('admin.terms-sections.index'));

        $this->assertSame(8, TermsSection::query()->firstOrFail()->sort_order);
    }

    public function test_validation_fails_for_invalid_terms_sections(): void
    {
        $this->actingAs($this->admin())
            ->post(route('admin.terms-sections.store'), [
                'number' => 0,
                'title' => '',
                'body' => '',
            ])
            ->assertSessionHasErrors(['number', 'title', 'body']);

        $this->assertSame(0, TermsSection::query()->count());
    }

    public function test_admin_can_update_a_terms_section(): void
    {
        $section = TermsSection::factory()->create([
            'number' => 2,
            'title' => 'Old Terms',
            'body' => 'Old body.',
        ]);

        $this->actingAs($this->admin())
            ->put(route('admin.terms-sections.update', $section), [
                'number' => 3,
                'title' => 'New Terms',
                'nav_title' => 'New Navigation',
                'body' => 'New body.',
                'sort_order' => 9,
            ])
            ->assertRedirect(route('admin.terms-sections.index'));

        $section->refresh();

        $this->assertSame(3, $section->number);
        $this->assertSame('New Terms', $section->title);
        $this->assertSame('New Navigation', $section->navTitle());
        $this->assertSame('New body.', $section->body);
        $this->assertSame(9, $section->sort_order);
    }

    public function test_admin_can_delete_a_terms_section(): void
    {
        $section = TermsSection::factory()->create();

        $this->actingAs($this->admin())
            ->delete(route('admin.terms-sections.destroy', $section))
            ->assertRedirect(route('admin.terms-sections.index'));

        $this->assertDatabaseMissing('terms_sections', ['id' => $section->id]);
    }

    private function admin(): User
    {
        $user = User::factory()->create();
        $user->forceFill(['is_admin' => true])->save();

        return $user;
    }
}
