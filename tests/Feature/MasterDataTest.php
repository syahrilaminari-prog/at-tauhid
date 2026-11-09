<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MasterDataTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_master_data_page(): void
    {
        $adminRole = Role::create([
            'name' => 'Admin',
            'slug' => 'admin',
            'description' => 'Administrator sistem',
        ]);

        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin.master@test.com',
            'role_id' => $adminRole->id,
        ]);

        $response = $this->actingAs($admin)->get('/admin/master-data');

        $response->assertOk();
        $response->assertSee('Master Data Kelas');
        $response->assertSee('Jurusan');
    }

    public function test_admin_can_add_major_and_class_data(): void
    {
        Storage::fake('local');

        $adminRole = Role::create([
            'name' => 'Admin',
            'slug' => 'admin',
            'description' => 'Administrator sistem',
        ]);

        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin.master2@test.com',
            'role_id' => $adminRole->id,
        ]);

        $this->actingAs($admin)
            ->post('/admin/master-data/jurusan', [
                'nama' => 'Tahfidz',
                'kode' => 'THF',
                'deskripsi' => 'Program tahfidz dan hafalan Qur\'an',
                'image' => UploadedFile::fake()->image('jurusan.png'),
            ])
            ->assertRedirect('/admin/master-data');

        $this->actingAs($admin)
            ->post('/admin/master-data/kelas', [
                'nama' => 'VII-A',
                'tingkat' => 'VII',
                'kapasitas' => 35,
                'jurusan_id' => 1,
                'image' => UploadedFile::fake()->image('kelas.png'),
            ])
            ->assertRedirect('/admin/master-data');

        $this->assertDatabaseHas('majors', [
            'kode' => 'THF',
            'nama' => 'Tahfidz',
        ]);

        $this->assertDatabaseHas('classes', [
            'nama' => 'VII-A',
            'tingkat' => 'VII',
            'kapasitas' => 35,
        ]);
        $this->assertDatabaseCount('image_attachments', 2);
    }
}
