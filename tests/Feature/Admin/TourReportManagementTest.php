<?php

namespace Tests\Feature\Admin;

use App\Models\TourReport;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class TourReportManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_admin_users_cannot_access_tour_reports(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('admin.tour-reports.index'))
            ->assertForbidden();
    }

    public function test_admin_can_see_the_report_listing(): void
    {
        $report = TourReport::factory()->create(['title' => 'Borneo 2026 Report']);

        $this->actingAs($this->admin())
            ->get(route('admin.tour-reports.index'))
            ->assertOk()
            ->assertSee('Borneo 2026 Report')
            ->assertSee($report->slug);
    }

    public function test_admin_can_create_a_report_with_a_cover_image(): void
    {
        Storage::fake('public_uploads');

        $this->actingAs($this->admin())
            ->post(route('admin.tour-reports.store'), [
                'title' => 'Borneo 2026 Report',
                'region' => 'Borneo',
                'summary' => 'A fantastic two weeks in the rainforest.',
                'report_url' => 'https://example.com/reports/borneo-2026.pdf',
                'published_at' => '2026-10-01',
                'is_featured' => '1',
                'is_published' => '1',
                'sort_order' => 1,
                'cover_image_file' => UploadedFile::fake()->image('cover.jpg'),
            ])
            ->assertRedirect(route('admin.tour-reports.index'));

        $report = TourReport::query()->where('slug', 'borneo-2026-report')->firstOrFail();

        $this->assertSame('Borneo', $report->region);
        $this->assertTrue($report->is_featured);
        $this->assertTrue($report->is_published);
        $this->assertSame('2026-10-01', $report->published_at?->format('Y-m-d'));
        $this->assertNotNull($report->cover_image);
        Storage::disk('public_uploads')->assertExists($report->cover_image);
    }

    public function test_admin_can_update_a_report(): void
    {
        $report = TourReport::factory()->create([
            'title' => 'Old Report',
            'slug' => 'old-report',
            'is_featured' => true,
        ]);

        $this->actingAs($this->admin())
            ->put(route('admin.tour-reports.update', $report), [
                'title' => 'New Report',
                'slug' => 'new-report',
                'region' => 'Sulawesi',
                'is_featured' => '0',
                'is_published' => '0',
            ])
            ->assertRedirect(route('admin.tour-reports.index'));

        $report->refresh();

        $this->assertSame('New Report', $report->title);
        $this->assertSame('new-report', $report->slug);
        $this->assertSame('Sulawesi', $report->region);
        $this->assertFalse($report->is_featured);
        $this->assertFalse($report->is_published);
    }

    public function test_updating_with_a_new_cover_image_replaces_the_old_file(): void
    {
        Storage::fake('public_uploads');
        Storage::disk('public_uploads')->put('reports/old.jpg', 'old-image');

        $report = TourReport::factory()->create(['cover_image' => 'reports/old.jpg']);

        $this->actingAs($this->admin())
            ->put(route('admin.tour-reports.update', $report), [
                'title' => $report->title,
                'slug' => $report->slug,
                'cover_image_file' => UploadedFile::fake()->image('new.jpg'),
            ])
            ->assertRedirect(route('admin.tour-reports.index'));

        Storage::disk('public_uploads')->assertMissing('reports/old.jpg');
        Storage::disk('public_uploads')->assertExists($report->refresh()->cover_image);
    }

    public function test_admin_can_remove_the_cover_image(): void
    {
        Storage::fake('public_uploads');
        Storage::disk('public_uploads')->put('reports/old.jpg', 'old-image');

        $report = TourReport::factory()->create(['cover_image' => 'reports/old.jpg']);

        $this->actingAs($this->admin())
            ->put(route('admin.tour-reports.update', $report), [
                'title' => $report->title,
                'slug' => $report->slug,
                'remove_image' => '1',
            ])
            ->assertRedirect(route('admin.tour-reports.index'));

        Storage::disk('public_uploads')->assertMissing('reports/old.jpg');
        $this->assertNull($report->refresh()->cover_image);
    }

    public function test_admin_can_delete_a_report(): void
    {
        $report = TourReport::factory()->create();

        $this->actingAs($this->admin())
            ->delete(route('admin.tour-reports.destroy', $report))
            ->assertRedirect(route('admin.tour-reports.index'));

        $this->assertDatabaseMissing('tour_reports', ['id' => $report->id]);
    }

    public function test_the_listing_can_be_filtered_by_featured_status(): void
    {
        TourReport::factory()->create(['title' => 'Featured Report', 'is_featured' => true]);
        TourReport::factory()->create(['title' => 'Standard Report', 'is_featured' => false]);

        $this->actingAs($this->admin())
            ->get(route('admin.tour-reports.index', ['featured' => '1']))
            ->assertOk()
            ->assertSee('Featured Report')
            ->assertDontSee('Standard Report');
    }

    private function admin(): User
    {
        $user = User::factory()->create();
        $user->forceFill(['is_admin' => true])->save();

        return $user;
    }
}
