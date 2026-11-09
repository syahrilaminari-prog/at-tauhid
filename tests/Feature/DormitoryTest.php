<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DormitoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_dormitory_page(): void
    {
        $adminRole = Role::create([
            'name' => 'Admin',
            'slug' => 'admin',
            'description' => 'Administrator sistem',
        ]);

        $admin = User::factory()->create([
            'name' => 'Admin Dormitory',
            'email' => 'admin.dormitory@test.com',
            'role_id' => $adminRole->id,
        ]);

        $response = $this->actingAs($admin)->get('/admin/asrama');

        $response->assertOk();
        $response->assertSee('Asrama Santri');
    }

    public function test_admin_can_store_dormitory_record(): void
    {
        Storage::fake('local');

        $adminRole = Role::create([
            'name' => 'Admin',
            'slug' => 'admin',
            'description' => 'Administrator sistem',
        ]);

        $admin = User::factory()->create([
            'name' => 'Admin Dormitory 2',
            'email' => 'admin.dormitory2@test.com',
            'role_id' => $adminRole->id,
        ]);

        $student = Student::create([
            'nama' => 'Faris Nabil',
            'nis' => '2026005',
            'jenis_kelamin' => 'Laki-laki',
            'tanggal_lahir' => '2016-08-21',
            'kelas' => 'VIII-B',
            'tahun_masuk' => 2026,
            'status' => 'Aktif',
            'alamat' => 'Jl. Mawar No. 14',
            'telepon' => '081233344455',
            'nama_ayah' => 'Nabil',
            'nama_ibu' => 'Laila',
        ]);

        $response = $this->actingAs($admin)
            ->post('/admin/asrama', [
                'student_id' => $student->id,
                'nama_kamar' => 'Putra 1',
                'kapasitas' => 30,
                'keterangan' => 'Kamar baru untuk santri putra.',
                'image' => UploadedFile::fake()->image('foto-asrama.png'),
            ]);

        $response->assertRedirect('/admin/asrama');
        $this->assertDatabaseHas('dormitories', [
            'student_id' => $student->id,
            'nama_kamar' => 'Putra 1',
            'kapasitas' => 30,
        ]);
        $this->assertDatabaseCount('image_attachments', 1);
    }
}
