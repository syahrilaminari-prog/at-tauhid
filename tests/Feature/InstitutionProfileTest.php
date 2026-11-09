<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\InstitutionProfileSection;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InstitutionProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_open_institution_profile_management(): void
    {
        $role = Role::create([
            'name' => 'Admin',
            'slug' => 'admin',
            'description' => 'Administrator sistem',
        ]);
        $admin = User::factory()->create(['role_id' => $role->id]);

        $this->actingAs($admin)
            ->get('/admin/profil')
            ->assertOk()
            ->assertSee('Kelola Profil Pesantren');
    }

    public function test_non_admin_cannot_open_institution_profile_management(): void
    {
        $role = Role::create([
            'name' => 'Santri',
            'slug' => 'santri',
            'description' => 'Santri aktif',
        ]);
        $student = User::factory()->create(['role_id' => $role->id]);

        $this->actingAs($student)->get('/admin/profil')->assertForbidden();
    }

    public function test_admin_can_create_update_and_delete_profile_section(): void
    {
        $role = Role::create([
            'name' => 'Admin',
            'slug' => 'admin',
            'description' => 'Administrator sistem',
        ]);
        $admin = User::factory()->create(['role_id' => $role->id]);

        $this->actingAs($admin)
            ->post('/admin/profil', [
                'section_type' => 'history',
                'slug' => 'sejarah-unit-test',
                'title' => 'Sejarah Uji',
                'content' => 'Konten sejarah awal.',
                'sort_order' => 1,
                'is_published' => 1,
            ])
            ->assertRedirect('/admin/profil');

        $section = InstitutionProfileSection::where('slug', 'sejarah-unit-test')->firstOrFail();
        $this->assertSame('Konten sejarah awal.', $section->content);

        $this->actingAs($admin)
            ->patch(route('admin.profil.update', $section), [
                'section_type' => 'history',
                'slug' => 'sejarah-unit-test',
                'title' => 'Sejarah Uji Diperbarui',
                'content' => 'Konten sejarah terbaru.',
                'sort_order' => 2,
                'is_published' => 1,
            ])
            ->assertRedirect('/admin/profil');

        $this->assertDatabaseHas('institution_profile_sections', [
            'id' => $section->id,
            'title' => 'Sejarah Uji Diperbarui',
            'content' => 'Konten sejarah terbaru.',
            'sort_order' => 2,
        ]);

        $this->actingAs($admin)
            ->delete(route('admin.profil.destroy', $section))
            ->assertRedirect('/admin/profil');

        $this->assertDatabaseMissing('institution_profile_sections', ['id' => $section->id]);
    }

    public function test_public_profile_shows_published_sections_and_hides_drafts(): void
    {
        InstitutionProfileSection::create([
            'section_type' => 'history',
            'slug' => 'sejarah-publik-uji',
            'title' => 'Sejarah Publik Uji',
            'content' => 'Konten yang dipublikasikan.',
            'sort_order' => 1,
            'is_published' => true,
        ]);
        InstitutionProfileSection::create([
            'section_type' => 'history',
            'slug' => 'sejarah-draft-uji',
            'title' => 'Sejarah Draft Rahasia',
            'content' => 'Konten yang masih draft.',
            'sort_order' => 2,
            'is_published' => false,
        ]);

        $this->get('/profil')
            ->assertOk()
            ->assertSee('Sejarah Publik Uji')
            ->assertSee('Konten yang dipublikasikan.')
            ->assertDontSee('Sejarah Draft Rahasia')
            ->assertDontSee('Konten yang masih draft.');
    }
}