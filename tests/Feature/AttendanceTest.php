<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AttendanceTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_attendance_page(): void
    {
        $adminRole = Role::create([
            'name' => 'Admin',
            'slug' => 'admin',
            'description' => 'Administrator sistem',
        ]);

        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin.attendance@test.com',
            'role_id' => $adminRole->id,
        ]);

        $response = $this->actingAs($admin)->get('/admin/kehadiran');

        $response->assertOk();
        $response->assertSee('Kehadiran Santri');
    }

    public function test_admin_can_store_attendance(): void
    {
        Storage::fake('local');

        $adminRole = Role::create([
            'name' => 'Admin',
            'slug' => 'admin',
            'description' => 'Administrator sistem',
        ]);

        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin.attendance2@test.com',
            'role_id' => $adminRole->id,
        ]);

        $student = Student::create([
            'nama' => 'Rifki Anwar',
            'nis' => '2026002',
            'jenis_kelamin' => 'Laki-laki',
            'tanggal_lahir' => '2013-11-12',
            'kelas' => 'VIII-B',
            'tahun_masuk' => 2026,
            'status' => 'Aktif',
            'alamat' => 'Jl. Mawar No. 8',
            'telepon' => '081212121212',
            'nama_ayah' => 'Bahar',
            'nama_ibu' => 'Ningsih',
        ]);

        $response = $this->actingAs($admin)
            ->post('/admin/kehadiran', [
                'student_id' => $student->id,
                'tanggal' => '2026-10-22',
                'status' => 'Hadir',
                'keterangan' => 'Tepat waktu',
                'image' => UploadedFile::fake()->image('bukti-kehadiran.jpg'),
            ]);

        $response->assertRedirect('/admin/kehadiran');
        $this->assertDatabaseHas('attendances', [
            'student_id' => $student->id,
            'status' => 'Hadir',
            'tanggal' => '2026-10-22',
        ]);
        $this->assertDatabaseCount('image_attachments', 1);
    }
}
