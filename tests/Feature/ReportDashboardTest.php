<?php

namespace Tests\Feature;

use App\Models\Attendance;
use App\Models\Bill;
use App\Models\Grade;
use App\Models\HealthRecord;
use App\Models\Role;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReportDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_summary_dashboard_and_report(): void
    {
        $adminRole = Role::create([
            'name' => 'Admin',
            'slug' => 'admin',
            'description' => 'Administrator sistem',
        ]);

        $admin = User::factory()->create([
            'name' => 'Laporan Admin',
            'email' => 'laporan.admin@test.com',
            'role_id' => $adminRole->id,
        ]);

        $student1 = Student::create([
            'nama' => 'Santri 1',
            'nis' => '2027001',
            'jenis_kelamin' => 'Laki-laki',
            'tanggal_lahir' => '2016-05-01',
            'kelas' => 'VIII-A',
            'tahun_masuk' => 2027,
            'status' => 'Aktif',
            'alamat' => 'Jl. A',
            'telepon' => '08111111111',
            'nama_ayah' => 'Ayah 1',
            'nama_ibu' => 'Ibu 1',
        ]);

        $student2 = Student::create([
            'nama' => 'Santri 2',
            'nis' => '2027002',
            'jenis_kelamin' => 'Perempuan',
            'tanggal_lahir' => '2016-07-20',
            'kelas' => 'VIII-A',
            'tahun_masuk' => 2027,
            'status' => 'Aktif',
            'alamat' => 'Jl. B',
            'telepon' => '08112222222',
            'nama_ayah' => 'Ayah 2',
            'nama_ibu' => 'Ibu 2',
        ]);

        Attendance::create([
            'student_id' => $student1->id,
            'tanggal' => now()->toDateString(),
            'status' => 'Hadir',
            'keterangan' => 'Hadir tepat waktu',
        ]);

        Bill::create([
            'student_id' => $student2->id,
            'jenis' => 'SPP',
            'nominal' => 550000,
            'tanggal_jatuh_tempo' => now()->addDays(5)->toDateString(),
            'status' => 'Belum Bayar',
            'keterangan' => 'Tagihan bulan ini',
        ]);

        HealthRecord::create([
            'student_id' => $student1->id,
            'jenis_pemeriksaan' => 'Pemeriksaan Fisik',
            'tanggal_pemeriksaan' => now()->toDateString(),
            'status_kesehatan' => 'Sehat',
            'catatan' => 'Tidak ada keluhan',
        ]);

        Grade::create([
            'student_id' => $student2->id,
            'mata_pelajaran' => 'Matematika',
            'semester' => 'Ganjil',
            'nilai' => 88,
            'keterangan' => 'Baik',
        ]);

        $response = $this->actingAs($admin)->get('/admin/laporan');

        $response->assertOk();
        $response->assertSee('Ringkasan Operasional');
        $response->assertSee('Total Santri');
        $response->assertSee('Tagihan Belum Bayar');
        $response->assertSee('Kesehatan');
    }
}
