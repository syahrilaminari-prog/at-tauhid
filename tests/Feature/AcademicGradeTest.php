<?php

namespace Tests\Feature;

use App\Models\Grade;
use App\Models\Role;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AcademicGradeTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_academic_page(): void
    {
        $adminRole = Role::create([
            'name' => 'Admin',
            'slug' => 'admin',
            'description' => 'Administrator sistem',
        ]);

        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin.academic@test.com',
            'role_id' => $adminRole->id,
        ]);

        $response = $this->actingAs($admin)->get('/admin/akademik');

        $response->assertOk();
        $response->assertSee('Nilai Akademik');
    }

    public function test_admin_can_store_academic_grade(): void
    {
        Storage::fake('local');

        $adminRole = Role::create([
            'name' => 'Admin',
            'slug' => 'admin',
            'description' => 'Administrator sistem',
        ]);

        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin.academic2@test.com',
            'role_id' => $adminRole->id,
        ]);

        $student = Student::create([
            'nama' => 'Siti Rahma',
            'nis' => '2026003',
            'jenis_kelamin' => 'Perempuan',
            'tanggal_lahir' => '2014-09-02',
            'kelas' => 'VII-B',
            'tahun_masuk' => 2026,
            'status' => 'Aktif',
            'alamat' => 'Jl. Melati No. 2',
            'telepon' => '081298765432',
            'nama_ayah' => 'Agus',
            'nama_ibu' => 'Maya',
        ]);

        $response = $this->actingAs($admin)
            ->post('/admin/akademik', [
                'student_id' => $student->id,
                'mata_pelajaran' => 'Al-Qur\'an',
                'semester' => 'Ganjil',
                'nilai' => 92,
                'keterangan' => 'Sangat baik',
                'image' => UploadedFile::fake()->image('lembar-nilai.png'),
            ]);

        $response->assertRedirect('/admin/akademik');
        $this->assertDatabaseHas('grades', [
            'student_id' => $student->id,
            'mata_pelajaran' => 'Al-Qur\'an',
            'nilai' => 92,
        ]);
        $this->assertCount(1, Grade::first()->imageAttachments);
    }
}
