<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserRoleManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_user_management_page(): void
    {
        $adminRole = Role::create([
            'name' => 'Admin',
            'slug' => 'admin',
            'description' => 'Administrator sistem',
        ]);

        $admin = User::factory()->create([
            'name' => 'Admin User Management',
            'email' => 'admin.user.management@test.com',
            'role_id' => $adminRole->id,
        ]);

        $response = $this->actingAs($admin)->get('/admin/users');

        $response->assertOk();
        $response->assertSee('Manajemen Pengguna');
    }

    public function test_admin_can_create_user_with_role(): void
    {
        Storage::fake('local');

        $adminRole = Role::create([
            'name' => 'Admin',
            'slug' => 'admin',
            'description' => 'Administrator sistem',
        ]);

        $teacherRole = Role::create([
            'name' => 'Ustadz',
            'slug' => 'ustadz',
            'description' => 'Pengajar',
        ]);

        $admin = User::factory()->create([
            'name' => 'Admin Role Assign',
            'email' => 'admin.role.assign@test.com',
            'role_id' => $adminRole->id,
        ]);

        $response = $this->actingAs($admin)
            ->post('/admin/users', [
                'name' => 'Budi Santoso',
                'email' => 'budi@pesantren.test',
                'password' => 'password123',
                'password_confirmation' => 'password123',
                'role_id' => $teacherRole->id,
                'image' => UploadedFile::fake()->image('foto-ustadz.png'),
            ]);

        $response->assertRedirect('/admin/users');
        $this->assertDatabaseHas('users', [
            'email' => 'budi@pesantren.test',
            'role_id' => $teacherRole->id,
        ]);

        $managedUser = User::where('email', 'budi@pesantren.test')->firstOrFail();
        $this->assertCount(1, $managedUser->imageAttachments);
        Storage::disk('local')->assertExists($managedUser->imageAttachments->first()->path);
    }
}
