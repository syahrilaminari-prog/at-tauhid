<?php

namespace Tests\Feature;

use App\Models\HealthRecord;
use App\Models\Role;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StudentManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_student_management_page(): void
    {
        $adminRole = Role::create([
            'name' => 'Admin',
            'slug' => 'admin',
            'description' => 'Administrator sistem',
        ]);

        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@student.test',
            'role_id' => $adminRole->id,
        ]);

        $response = $this->actingAs($admin)->get('/admin/santri');

        $response->assertOk();
        $response->assertSee('Manajemen Santri');
    }

    public function test_admin_can_create_student_record(): void
    {
        $adminRole = Role::create([
            'name' => 'Admin',
            'slug' => 'admin',
            'description' => 'Administrator sistem',
        ]);

        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin2@student.test',
            'role_id' => $adminRole->id,
        ]);

        $response = $this->actingAs($admin)
            ->post('/admin/santri', [
                'nama' => 'Ahmad Fauzi',
                'nis' => '2026001',
                'jenis_kelamin' => 'Laki-laki',
                'tanggal_lahir' => '2014-05-10',
                'kelas' => 'VII-A',
                'tahun_masuk' => '2026',
                'status' => 'Aktif',
                'alamat' => 'Jl. Merdeka No. 12',
                'telepon' => '081234567890',
                'nama_ayah' => 'Budi',
                'nama_ibu' => 'Siti',
                'email_orang_tua' => 'wali.ahmad@test.com',
                'password_orang_tua' => 'waliPass123',
                'password_orang_tua_confirmation' => 'waliPass123',
            ]);

        $response->assertRedirect('/admin/santri');
        $this->assertDatabaseHas('students', [
            'nis' => '2026001',
            'nama' => 'Ahmad Fauzi',
        ]);
        $this->assertEquals(1, Student::count());
    }

    public function test_creating_student_creates_and_links_parent_user(): void
    {
        $adminRole = Role::create([
            'name' => 'Admin',
            'slug' => 'admin',
            'description' => 'Administrator sistem',
        ]);
        $admin = User::factory()->create(['role_id' => $adminRole->id]);

        $this->actingAs($admin)
            ->post('/admin/santri', [
                'nama' => 'Santri Dengan Wali',
                'nis' => '2026015',
                'jenis_kelamin' => 'Perempuan',
                'tanggal_lahir' => '2014-06-12',
                'kelas' => 'VII-A',
                'tahun_masuk' => 2026,
                'status' => 'Aktif',
                'nama_ayah' => 'Bapak Wali Demo',
                'email_orang_tua' => 'wali.santri.demo@test.com',
                'password_orang_tua' => 'waliDemo123',
                'password_orang_tua_confirmation' => 'waliDemo123',
            ])
            ->assertRedirect('/admin/santri');

        $parent = User::where('email', 'wali.santri.demo@test.com')->firstOrFail();
        $student = Student::where('nis', '2026015')->firstOrFail();

        $this->assertSame('orang_tua', $parent->role->slug);
        $this->assertTrue(password_verify('waliDemo123', $parent->password));
        $this->assertDatabaseHas('student_parent_links', [
            'user_id' => $parent->id,
            'student_id' => $student->id,
            'hubungan' => 'Ayah',
            'status' => 'aktif',
        ]);
    }

    public function test_admin_can_upload_a_student_image(): void
    {
        Storage::fake('local');

        $adminRole = Role::create([
            'name' => 'Admin',
            'slug' => 'admin',
            'description' => 'Administrator sistem',
        ]);

        $admin = User::factory()->create(['role_id' => $adminRole->id]);

        $this->actingAs($admin)
            ->post('/admin/santri', [
                'nama' => 'Ahmad Fauzi',
                'nis' => '2026007',
                'jenis_kelamin' => 'Laki-laki',
                'tanggal_lahir' => '2014-05-10',
                'kelas' => 'VII-A',
                'tahun_masuk' => '2026',
                'status' => 'Aktif',
                'nama_ayah' => 'Bapak Fauzi',
                'nama_ibu' => 'Ibu Siti',
                'email_orang_tua' => 'wali.fauzi@test.com',
                'password_orang_tua' => 'waliPass123',
                'password_orang_tua_confirmation' => 'waliPass123',
                'image' => UploadedFile::fake()->image('foto-santri.jpg'),
            ])
            ->assertRedirect('/admin/santri');

        $student = Student::where('nis', '2026007')->firstOrFail();
        $attachment = $student->imageAttachments()->firstOrFail();
        $this->assertSame($admin->id, $attachment->uploaded_by);
        $this->assertSame('foto-santri.jpg', $attachment->original_name);

        Storage::disk('local')->assertExists($attachment->path);

        $this->actingAs($admin)
            ->get(route('image-attachments.show', $attachment))
            ->assertOk()
            ->assertHeader('Content-Type', 'image/jpeg');

        $parentRole = Role::where('slug', 'orang_tua')->firstOrFail();
        $parent = User::factory()->create(['role_id' => $parentRole->id]);
        $parent->students()->attach($student->id, ['hubungan' => 'Ibu', 'status' => 'aktif']);

        $this->actingAs($parent)
            ->get(route('image-attachments.show', $attachment))
            ->assertOk();

        $otherUser = User::factory()->create();
        $this->actingAs($otherUser)
            ->get(route('image-attachments.show', $attachment))
            ->assertForbidden();
    }

    public function test_admin_cannot_upload_a_non_image_file_as_a_student_photo(): void
    {
        Storage::fake('local');

        $adminRole = Role::create([
            'name' => 'Admin',
            'slug' => 'admin',
            'description' => 'Administrator sistem',
        ]);
        $admin = User::factory()->create(['role_id' => $adminRole->id]);

        $this->actingAs($admin)
            ->from('/admin/santri')
            ->post('/admin/santri', [
                'nama' => 'File Tidak Valid',
                'nis' => '2026008',
                'jenis_kelamin' => 'Perempuan',
                'tanggal_lahir' => '2014-05-10',
                'kelas' => 'VII-A',
                'tahun_masuk' => '2026',
                'status' => 'Aktif',
                'nama_ayah' => 'Bapak Tidak Valid',
                'email_orang_tua' => 'wali.invalid@test.com',
                'password_orang_tua' => 'waliPass123',
                'password_orang_tua_confirmation' => 'waliPass123',
                'image' => UploadedFile::fake()->create('script.svg', 20, 'image/svg+xml'),
            ])
            ->assertSessionHasErrors('image');

        $this->assertDatabaseMissing('students', ['nis' => '2026008']);
        $this->assertDatabaseCount('image_attachments', 0);
    }

    public function test_admin_can_open_student_edit_form(): void
    {
        $adminRole = Role::create([
            'name' => 'Admin',
            'slug' => 'admin',
            'description' => 'Administrator sistem',
        ]);
        $admin = User::factory()->create(['role_id' => $adminRole->id]);
        $student = Student::create([
            'nama' => 'Alya Rahma',
            'nis' => '2026010',
            'jenis_kelamin' => 'Perempuan',
            'tanggal_lahir' => '2014-06-12',
            'kelas' => 'VII-A',
            'tahun_masuk' => 2026,
            'status' => 'Aktif',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.santri.edit', $student))
            ->assertOk()
            ->assertSee('Edit Data Santri')
            ->assertSee('Alya Rahma');
    }

    public function test_admin_can_link_existing_parent_account_to_student(): void
    {
        $adminRole = Role::create([
            'name' => 'Admin',
            'slug' => 'admin',
            'description' => 'Administrator sistem',
        ]);
        $parentRole = Role::create([
            'name' => 'Orang Tua',
            'slug' => 'orang_tua',
            'description' => 'Orang tua santri',
        ]);
        $admin = User::factory()->create(['role_id' => $adminRole->id]);
        $parent = User::factory()->create([
            'name' => 'Wali Santri Demo',
            'email' => 'wali.link.demo@test.com',
            'role_id' => $parentRole->id,
        ]);
        $student = Student::create([
            'nama' => 'Santri Belum Terhubung',
            'nis' => '2026016',
            'jenis_kelamin' => 'Perempuan',
            'tanggal_lahir' => '2014-08-12',
            'kelas' => 'VII-A',
            'tahun_masuk' => 2026,
            'status' => 'Aktif',
        ]);

        $this->actingAs($admin)
            ->post(route('admin.santri.parent.store', $student), [
                'user_id' => $parent->id,
                'hubungan' => 'Ibu',
            ])
            ->assertRedirect(route('admin.santri.edit', $student));

        $this->assertDatabaseHas('student_parent_links', [
            'user_id' => $parent->id,
            'student_id' => $student->id,
            'hubungan' => 'Ibu',
            'status' => 'aktif',
        ]);

        $this->actingAs($parent)
            ->get('/orangtua')
            ->assertOk()
            ->assertSee('Santri Belum Terhubung');
    }

    public function test_parent_sees_health_history_only_for_linked_student(): void
    {
        Storage::fake('local');

        $parentRole = Role::create([
            'name' => 'Orang Tua',
            'slug' => 'orang_tua',
            'description' => 'Orang tua santri',
        ]);
        $parent = User::factory()->create(['role_id' => $parentRole->id]);
        $linkedStudent = Student::create([
            'nama' => 'Santri Terhubung',
            'nis' => '2026017',
            'jenis_kelamin' => 'Perempuan',
            'tanggal_lahir' => '2014-08-12',
            'kelas' => 'VII-A',
            'tahun_masuk' => 2026,
            'status' => 'Aktif',
        ]);
        $unlinkedStudent = Student::create([
            'nama' => 'Santri Tidak Terhubung',
            'nis' => '2026018',
            'jenis_kelamin' => 'Laki-laki',
            'tanggal_lahir' => '2014-09-12',
            'kelas' => 'VII-A',
            'tahun_masuk' => 2026,
            'status' => 'Aktif',
        ]);
        $healthRecord = $linkedStudent->healthRecords()->create([
            'jenis_pemeriksaan' => 'Kontrol perawatan',
            'tanggal_pemeriksaan' => '2026-11-08',
            'status_kesehatan' => 'Rawat',
            'catatan' => 'CATATAN-ANAK-TERHUBUNG',
        ]);
        $healthImage = UploadedFile::fake()->image('catatan-perawatan.jpg');
        $healthImagePath = $healthImage->store('images', 'local');
        $healthAttachment = $healthRecord->imageAttachments()->create([
            'uploaded_by' => $parent->id,
            'disk' => 'local',
            'path' => $healthImagePath,
            'original_name' => 'catatan-perawatan.jpg',
            'mime_type' => 'image/jpeg',
            'size' => $healthImage->getSize(),
        ]);
        $unlinkedStudent->healthRecords()->create([
            'jenis_pemeriksaan' => 'Pemeriksaan khusus',
            'tanggal_pemeriksaan' => '2026-11-08',
            'status_kesehatan' => 'Sakit',
            'catatan' => 'CATATAN-ANAK-RAHASIA-LAIN',
        ]);
        $parent->students()->attach($linkedStudent->id, ['hubungan' => 'Ibu', 'status' => 'aktif']);

        $this->actingAs($parent)
            ->get('/orangtua')
            ->assertOk()
            ->assertSee('Riwayat kesehatan dan perawatan')
            ->assertSee('CATATAN-ANAK-TERHUBUNG')
            ->assertSee('Lihat catatan-perawatan.jpg')
            ->assertDontSee('CATATAN-ANAK-RAHASIA-LAIN');

        $this->get(route('image-attachments.show', $healthAttachment))->assertOk();
    }

    public function test_admin_can_update_student_record_and_replace_photo(): void
    {
        Storage::fake('local');

        $adminRole = Role::create([
            'name' => 'Admin',
            'slug' => 'admin',
            'description' => 'Administrator sistem',
        ]);
        $admin = User::factory()->create(['role_id' => $adminRole->id]);
        $student = Student::create([
            'nama' => 'Alya Rahma',
            'nis' => '2026011',
            'jenis_kelamin' => 'Perempuan',
            'tanggal_lahir' => '2014-06-12',
            'kelas' => 'VII-A',
            'tahun_masuk' => 2026,
            'status' => 'Aktif',
        ]);
        $oldPath = 'images/old-student-photo.png';
        Storage::disk('local')->put($oldPath, 'old-image');
        $student->imageAttachments()->create([
            'uploaded_by' => $admin->id,
            'disk' => 'local',
            'path' => $oldPath,
            'original_name' => 'foto-lama.png',
            'mime_type' => 'image/png',
            'size' => 9,
        ]);

        $this->actingAs($admin)
            ->patch(route('admin.santri.update', $student), [
                'nama' => 'Alya Rahma Putri',
                'nis' => '2026011',
                'jenis_kelamin' => 'Perempuan',
                'tanggal_lahir' => '2014-06-12',
                'kelas' => 'VIII-A',
                'tahun_masuk' => 2026,
                'status' => 'Aktif',
                'image' => UploadedFile::fake()->image('foto-baru.png'),
            ])
            ->assertRedirect(route('admin.santri.index'));

        $this->assertDatabaseHas('students', [
            'id' => $student->id,
            'nama' => 'Alya Rahma Putri',
            'kelas' => 'VIII-A',
        ]);
        Storage::disk('local')->assertMissing($oldPath);
        $this->assertCount(1, $student->fresh()->imageAttachments);
        Storage::disk('local')->assertExists($student->fresh()->imageAttachments->first()->path);
    }

    public function test_student_update_rejects_another_students_nis(): void
    {
        $adminRole = Role::create([
            'name' => 'Admin',
            'slug' => 'admin',
            'description' => 'Administrator sistem',
        ]);
        $admin = User::factory()->create(['role_id' => $adminRole->id]);
        $firstStudent = Student::create([
            'nama' => 'Santri Satu',
            'nis' => '2026012',
            'jenis_kelamin' => 'Laki-laki',
            'tanggal_lahir' => '2014-06-12',
            'kelas' => 'VII-A',
            'tahun_masuk' => 2026,
            'status' => 'Aktif',
        ]);
        Student::create([
            'nama' => 'Santri Dua',
            'nis' => '2026013',
            'jenis_kelamin' => 'Perempuan',
            'tanggal_lahir' => '2014-07-12',
            'kelas' => 'VII-A',
            'tahun_masuk' => 2026,
            'status' => 'Aktif',
        ]);

        $this->actingAs($admin)
            ->from(route('admin.santri.edit', $firstStudent))
            ->patch(route('admin.santri.update', $firstStudent), [
                'nama' => 'Santri Satu',
                'nis' => '2026013',
                'jenis_kelamin' => 'Laki-laki',
                'tanggal_lahir' => '2014-06-12',
                'kelas' => 'VII-A',
                'tahun_masuk' => 2026,
                'status' => 'Aktif',
            ])
            ->assertSessionHasErrors('nis');

        $this->assertSame('2026012', $firstStudent->fresh()->nis);
    }

    public function test_deleting_student_removes_related_records_and_private_images(): void
    {
        Storage::fake('local');

        $adminRole = Role::create([
            'name' => 'Admin',
            'slug' => 'admin',
            'description' => 'Administrator sistem',
        ]);
        $admin = User::factory()->create(['role_id' => $adminRole->id]);
        $student = Student::create([
            'nama' => 'Santri Hapus',
            'nis' => '2026014',
            'jenis_kelamin' => 'Laki-laki',
            'tanggal_lahir' => '2014-08-12',
            'kelas' => 'VII-A',
            'tahun_masuk' => 2026,
            'status' => 'Aktif',
        ]);
        $healthRecord = HealthRecord::create([
            'student_id' => $student->id,
            'jenis_pemeriksaan' => 'Pemeriksaan rutin',
            'tanggal_pemeriksaan' => '2026-11-09',
            'status_kesehatan' => 'Sehat',
        ]);

        $studentImagePath = 'images/student-delete.png';
        $healthImagePath = 'images/health-delete.png';
        Storage::disk('local')->put($studentImagePath, 'student-image');
        Storage::disk('local')->put($healthImagePath, 'health-image');

        $student->imageAttachments()->create([
            'uploaded_by' => $admin->id,
            'disk' => 'local',
            'path' => $studentImagePath,
            'original_name' => 'student.png',
            'mime_type' => 'image/png',
            'size' => 13,
        ]);
        $healthRecord->imageAttachments()->create([
            'uploaded_by' => $admin->id,
            'disk' => 'local',
            'path' => $healthImagePath,
            'original_name' => 'health.png',
            'mime_type' => 'image/png',
            'size' => 12,
        ]);

        $this->actingAs($admin)
            ->delete(route('admin.santri.destroy', $student))
            ->assertRedirect(route('admin.santri.index'));

        $this->assertModelMissing($student);
        $this->assertModelMissing($healthRecord);
        $this->assertDatabaseCount('image_attachments', 0);
        Storage::disk('local')->assertMissing($studentImagePath);
        Storage::disk('local')->assertMissing($healthImagePath);
    }
}
