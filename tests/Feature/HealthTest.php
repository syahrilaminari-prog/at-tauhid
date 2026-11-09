<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class HealthTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_health_page(): void
    {
        $adminRole = Role::create([
            'name' => 'Admin',
            'slug' => 'admin',
            'description' => 'Administrator sistem',
        ]);

        $admin = User::factory()->create([
            'name' => 'Admin Health',
            'email' => 'admin.health@test.com',
            'role_id' => $adminRole->id,
        ]);

        $response = $this->actingAs($admin)->get('/admin/kesehatan');

        $response->assertOk();
        $response->assertSee('Kesehatan Santri');
    }

    public function test_admin_can_store_health_record(): void
    {
        Storage::fake('local');

        $adminRole = Role::create([
            'name' => 'Admin',
            'slug' => 'admin',
            'description' => 'Administrator sistem',
        ]);

        $admin = User::factory()->create([
            'name' => 'Admin Health 2',
            'email' => 'admin.health2@test.com',
            'role_id' => $adminRole->id,
        ]);

        $student = Student::create([
            'nama' => 'Nadia Afifah',
            'nis' => '2026006',
            'jenis_kelamin' => 'Perempuan',
            'tanggal_lahir' => '2017-02-15',
            'kelas' => 'VIII-C',
            'tahun_masuk' => 2026,
            'status' => 'Aktif',
            'alamat' => 'Jl. Melati No. 7',
            'telepon' => '081299988877',
            'nama_ayah' => 'Rizal',
            'nama_ibu' => 'Novi',
        ]);

        $response = $this->actingAs($admin)
            ->post('/admin/kesehatan', [
                'student_id' => $student->id,
                'jenis_pemeriksaan' => 'Pemeriksaan Fisik',
                'tanggal_pemeriksaan' => '2026-10-22',
                'status_kesehatan' => 'Sehat',
                'catatan' => 'Tidak ada keluhan berarti.',
                'image' => UploadedFile::fake()->image('catatan-perawatan.webp'),
            ]);

        $response->assertRedirect('/admin/kesehatan');
        $this->assertDatabaseHas('health_records', [
            'student_id' => $student->id,
            'jenis_pemeriksaan' => 'Pemeriksaan Fisik',
            'status_kesehatan' => 'Sehat',
        ]);
        $this->assertDatabaseCount('image_attachments', 1);
    }
}
