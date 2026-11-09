<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BillingTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_billing_page(): void
    {
        $adminRole = Role::create([
            'name' => 'Admin',
            'slug' => 'admin',
            'description' => 'Administrator sistem',
        ]);

        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin.billing@test.com',
            'role_id' => $adminRole->id,
        ]);

        $response = $this->actingAs($admin)->get('/admin/tagihan');

        $response->assertOk();
        $response->assertSee('Tagihan Santri');
    }

    public function test_admin_can_store_billing_record(): void
    {
        Storage::fake('local');

        $adminRole = Role::create([
            'name' => 'Admin',
            'slug' => 'admin',
            'description' => 'Administrator sistem',
        ]);

        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin.billing2@test.com',
            'role_id' => $adminRole->id,
        ]);

        $student = Student::create([
            'nama' => 'Azzam Putra',
            'nis' => '2026004',
            'jenis_kelamin' => 'Laki-laki',
            'tanggal_lahir' => '2015-03-10',
            'kelas' => 'VIII-A',
            'tahun_masuk' => 2026,
            'status' => 'Aktif',
            'alamat' => 'Jl. Kenanga No. 9',
            'telepon' => '081255566677',
            'nama_ayah' => 'Dedi',
            'nama_ibu' => 'Lina',
        ]);

        $response = $this->actingAs($admin)
            ->post('/admin/tagihan', [
                'student_id' => $student->id,
                'jenis' => 'SPP',
                'nominal' => 550000,
                'tanggal_jatuh_tempo' => '2026-10-30',
                'status' => 'Belum Bayar',
                'keterangan' => 'Tagihan bulan Oktober',
                'image' => UploadedFile::fake()->image('bukti-tagihan.jpg'),
            ]);

        $response->assertRedirect('/admin/tagihan');
        $this->assertDatabaseHas('bills', [
            'student_id' => $student->id,
            'jenis' => 'SPP',
            'nominal' => 550000,
            'status' => 'Belum Bayar',
        ]);
        $this->assertDatabaseCount('image_attachments', 1);
    }
}
