<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Bill;
use App\Models\Dormitory;
use App\Models\Grade;
use App\Models\HealthRecord;
use App\Models\InstitutionProfileSection;
use App\Models\Major;
use App\Models\Role;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $adminRole = Role::firstOrCreate([
            'slug' => 'admin',
        ], [
            'name' => 'Admin',
            'description' => 'Administrator sistem',
        ]);

        $ustadzRole = Role::firstOrCreate([
            'slug' => 'ustadz',
        ], [
            'name' => 'Ustadz',
            'description' => 'Pengajar dan pembina santri',
        ]);

        $santriRole = Role::firstOrCreate([
            'slug' => 'santri',
        ], [
            'name' => 'Santri',
            'description' => 'Pengguna santri',
        ]);

        $parentRole = Role::firstOrCreate([
            'slug' => 'orang_tua',
        ], [
            'name' => 'Orang Tua',
            'description' => 'Orang tua / wali santri',
        ]);

        User::firstOrCreate(
            ['email' => 'admin@pesantren.test'],
            [
                'name' => 'Admin Pesantren',
                'password' => Hash::make('admin123'),
                'role_id' => $adminRole->id,
                'email_verified_at' => now(),
            ]
        );

        User::firstOrCreate(
            ['email' => 'ustadz@pesantren.test'],
            [
                'name' => 'Ustadz Ahmad',
                'password' => Hash::make('ustadz123'),
                'role_id' => $ustadzRole->id,
                'email_verified_at' => now(),
            ]
        );

        User::firstOrCreate(
            ['email' => 'santri@pesantren.test'],
            [
                'name' => 'Santri Demo',
                'password' => Hash::make('santri123'),
                'role_id' => $santriRole->id,
                'email_verified_at' => now(),
            ]
        );

        $parentUser = User::firstOrCreate(
            ['email' => 'orangtua@pesantren.test'],
            [
                'name' => 'Ibu Siti',
                'password' => Hash::make('wali123'),
                'role_id' => $parentRole->id,
                'email_verified_at' => now(),
            ]
        );

        $aisyahParent = User::firstOrCreate(
            ['email' => 'wali.aisyah@pesantren.test'],
            [
                'name' => 'Bapak Hasan',
                'password' => Hash::make('wali123'),
                'role_id' => $parentRole->id,
                'email_verified_at' => now(),
            ]
        );

        $fajarParent = User::firstOrCreate(
            ['email' => 'wali.fajar@pesantren.test'],
            [
                'name' => 'Bapak Arif',
                'password' => Hash::make('wali123'),
                'role_id' => $parentRole->id,
                'email_verified_at' => now(),
            ]
        );

        $ipa = Major::firstOrCreate(
            ['kode' => 'IPA'],
            ['nama' => 'Ilmu Pengetahuan Alam', 'deskripsi' => 'Jurusan sains dan teknologi']
        );

        $ips = Major::firstOrCreate(
            ['kode' => 'IPS'],
            ['nama' => 'Ilmu Pengetahuan Sosial', 'deskripsi' => 'Jurusan sosial dan humaniora']
        );

        $kelas7 = SchoolClass::firstOrCreate(
            ['nama' => 'VII-A'],
            ['tingkat' => 'VII', 'kapasitas' => 30, 'jurusan_id' => $ipa->id]
        );

        $kelas8 = SchoolClass::firstOrCreate(
            ['nama' => 'VIII-A'],
            ['tingkat' => 'VIII', 'kapasitas' => 30, 'jurusan_id' => $ips->id]
        );

        $santriList = [
            [
                'nama' => 'Ahmad Fauzi',
                'nis' => '2026001',
                'jenis_kelamin' => 'Laki-laki',
                'tanggal_lahir' => '2015-04-12',
                'kelas' => $kelas7->nama,
                'tahun_masuk' => 2026,
                'status' => 'Aktif',
                'alamat' => 'Jl. Merdeka No. 12, Bandung',
                'telepon' => '081234567890',
                'nama_ayah' => 'Bapak Fauzi',
                'nama_ibu' => 'Ibu Siti',
            ],
            [
                'nama' => 'Aisyah Putri',
                'nis' => '2026002',
                'jenis_kelamin' => 'Perempuan',
                'tanggal_lahir' => '2015-08-20',
                'kelas' => $kelas8->nama,
                'tahun_masuk' => 2026,
                'status' => 'Aktif',
                'alamat' => 'Jl. Cendana No. 7, Bandung',
                'telepon' => '081298765432',
                'nama_ayah' => 'Bapak Hasan',
                'nama_ibu' => 'Ibu Laila',
            ],
            [
                'nama' => 'Muhammad Rizky',
                'nis' => '2026003',
                'jenis_kelamin' => 'Laki-laki',
                'tanggal_lahir' => '2014-11-05',
                'kelas' => $kelas7->nama,
                'tahun_masuk' => 2025,
                'status' => 'Aktif',
                'alamat' => 'Jl. Diponegoro No. 20, Bandung',
                'telepon' => '081312345678',
                'nama_ayah' => 'Bapak Rizky',
                'nama_ibu' => 'Ibu Nani',
            ],
            [
                'nama' => 'Nur Aulia',
                'nis' => '2026004',
                'jenis_kelamin' => 'Perempuan',
                'tanggal_lahir' => '2014-05-17',
                'kelas' => $kelas8->nama,
                'tahun_masuk' => 2025,
                'status' => 'Aktif',
                'alamat' => 'Jl. Anggrek No. 14, Bandung',
                'telepon' => '081223344556',
                'nama_ayah' => 'Bapak Mahmud',
                'nama_ibu' => 'Ibu Rina',
            ],
            [
                'nama' => 'Fajar Maulana',
                'nis' => '2026005',
                'jenis_kelamin' => 'Laki-laki',
                'tanggal_lahir' => '2013-09-10',
                'kelas' => $kelas7->nama,
                'tahun_masuk' => 2024,
                'status' => 'Aktif',
                'alamat' => 'Jl. Melati No. 8, Cimahi',
                'telepon' => '081334455667',
                'nama_ayah' => 'Bapak Arif',
                'nama_ibu' => 'Ibu Dewi',
            ],
            [
                'nama' => 'Salma Zahra',
                'nis' => '2026006',
                'jenis_kelamin' => 'Perempuan',
                'tanggal_lahir' => '2014-02-25',
                'kelas' => $kelas8->nama,
                'tahun_masuk' => 2025,
                'status' => 'Aktif',
                'alamat' => 'Jl. Kenanga No. 3, Bandung',
                'telepon' => '081445566778',
                'nama_ayah' => 'Bapak Yusuf',
                'nama_ibu' => 'Ibu Nadia',
            ],
        ];

        foreach ($santriList as $data) {
            $student = Student::firstOrCreate(
                ['nis' => $data['nis']],
                $data
            );

            Attendance::firstOrCreate(
                [
                    'student_id' => $student->id,
                    'tanggal' => now()->toDateString(),
                ],
                [
                    'status' => 'Hadir',
                    'keterangan' => 'Hadir tepat waktu',
                ]
            );

            Grade::firstOrCreate(
                [
                    'student_id' => $student->id,
                    'mata_pelajaran' => 'Pendidikan Agama Islam',
                    'semester' => 'Ganjil',
                ],
                [
                    'nilai' => 90,
                    'keterangan' => 'Baik',
                ]
            );

            Bill::firstOrCreate(
                [
                    'student_id' => $student->id,
                    'jenis' => 'SPP',
                    'tanggal_jatuh_tempo' => now()->addDays(7)->toDateString(),
                ],
                [
                    'nominal' => 550000,
                    'status' => 'Belum Bayar',
                    'keterangan' => 'Tagihan bulan ini',
                ]
            );

            HealthRecord::firstOrCreate(
                [
                    'student_id' => $student->id,
                    'tanggal_pemeriksaan' => now()->toDateString(),
                ],
                [
                    'jenis_pemeriksaan' => 'Pemeriksaan Fisik',
                    'status_kesehatan' => 'Sehat',
                    'catatan' => 'Tidak ada keluhan kesehatan.',
                ]
            );
        }

        $demoStudents = Student::query()
            ->whereIn('nis', ['2026001', '2026002', '2026003', '2026004', '2026005', '2026006'])
            ->get()
            ->keyBy('nis');

        $attendanceSamples = [
            '2026001' => ['Hadir', 'Hadir', 'Izin', 'Hadir', 'Hadir'],
            '2026002' => ['Hadir', 'Hadir', 'Hadir', 'Hadir', 'Hadir'],
            '2026003' => ['Hadir', 'Hadir', 'Hadir', 'Alpha', 'Hadir'],
            '2026004' => ['Hadir', 'Hadir', 'Izin', 'Hadir', 'Hadir'],
            '2026005' => ['Hadir', 'Sakit', 'Sakit', 'Hadir', 'Hadir'],
            '2026006' => ['Sakit', 'Hadir', 'Hadir', 'Hadir', 'Izin'],
        ];
        $attendanceStart = now()->startOfWeek()->subWeek();

        foreach ($attendanceSamples as $nis => $statuses) {
            $student = $demoStudents->get($nis);

            foreach ($statuses as $dayOffset => $status) {
                Attendance::updateOrCreate(
                    [
                        'student_id' => $student->id,
                        'tanggal' => $attendanceStart->copy()->addDays($dayOffset)->toDateString(),
                    ],
                    [
                        'status' => $status,
                        'keterangan' => $status === 'Hadir' ? 'Hadir sesuai jadwal.' : 'Data dummy untuk pengujian absensi.',
                    ]
                );
            }
        }

        $gradeSamples = [
            '2026001' => ['Bahasa Arab' => 88, 'Tahfiz Al-Quran' => 91, 'Matematika' => 82],
            '2026002' => ['Bahasa Arab' => 92, 'Tahfiz Al-Quran' => 95, 'Matematika' => 89],
            '2026003' => ['Bahasa Arab' => 80, 'Tahfiz Al-Quran' => 84, 'Matematika' => 86],
            '2026004' => ['Bahasa Arab' => 90, 'Tahfiz Al-Quran' => 93, 'Matematika' => 88],
            '2026005' => ['Bahasa Arab' => 85, 'Tahfiz Al-Quran' => 87, 'Matematika' => 90],
            '2026006' => ['Bahasa Arab' => 94, 'Tahfiz Al-Quran' => 96, 'Matematika' => 91],
        ];

        foreach ($gradeSamples as $nis => $grades) {
            $student = $demoStudents->get($nis);

            foreach ($grades as $subject => $score) {
                Grade::firstOrCreate(
                    [
                        'student_id' => $student->id,
                        'mata_pelajaran' => $subject,
                        'semester' => 'Ganjil',
                    ],
                    [
                        'nilai' => $score,
                        'keterangan' => 'Nilai contoh untuk pengujian sistem.',
                    ]
                );
            }
        }

        $billingSamples = [
            ['jenis' => 'SPP November 2026', 'nominal' => 550000, 'day' => 9, 'status' => 'Sudah Bayar'],
            ['jenis' => 'Kegiatan Pesantren', 'nominal' => 150000, 'day' => 14, 'status' => 'Belum Bayar'],
        ];

        foreach ($demoStudents as $student) {
            foreach ($billingSamples as $bill) {
                Bill::firstOrCreate(
                    [
                        'student_id' => $student->id,
                        'jenis' => $bill['jenis'],
                        'tanggal_jatuh_tempo' => now()->startOfMonth()->addDays($bill['day'])->toDateString(),
                    ],
                    [
                        'nominal' => $bill['nominal'],
                        'status' => $bill['status'],
                        'keterangan' => 'Tagihan contoh untuk pengujian sistem.',
                    ]
                );
            }
        }

        $healthSamples = [
            ['nis' => '2026002', 'day' => 5, 'jenis' => 'Pemeriksaan rutin', 'status' => 'Sehat', 'catatan' => 'Data dummy: kondisi sehat dan tidak ada keluhan.'],
            ['nis' => '2026005', 'day' => 6, 'jenis' => 'Pemeriksaan kesehatan', 'status' => 'Sakit', 'catatan' => 'Data dummy: santri sedang sakit dan perlu pemantauan wali.'],
            ['nis' => '2026006', 'day' => 4, 'jenis' => 'Pemeriksaan rutin', 'status' => 'Catatan Khusus', 'catatan' => 'Data dummy: perlu pemantauan kesehatan berkala.'],
        ];
        $healthDate = now()->startOfWeek()->subWeek();

        foreach ($healthSamples as $sample) {
            $student = $demoStudents->get($sample['nis']);

            HealthRecord::updateOrCreate(
                [
                    'student_id' => $student->id,
                    'tanggal_pemeriksaan' => $healthDate->copy()->addDays($sample['day'])->toDateString(),
                ],
                [
                    'jenis_pemeriksaan' => $sample['jenis'],
                    'status_kesehatan' => $sample['status'],
                    'catatan' => $sample['catatan'],
                ]
            );
        }

        $sickStudent = $demoStudents->get('2026005');

        Attendance::updateOrCreate(
            [
                'student_id' => $sickStudent->id,
                'tanggal' => now()->toDateString(),
            ],
            [
                'status' => 'Sakit',
                'keterangan' => 'Data dummy: izin karena sakit.',
            ]
        );

        HealthRecord::updateOrCreate(
            [
                'student_id' => $sickStudent->id,
                'tanggal_pemeriksaan' => now()->toDateString(),
            ],
            [
                'jenis_pemeriksaan' => 'Pemeriksaan kesehatan',
                'status_kesehatan' => 'Sakit',
                'catatan' => 'Data dummy: santri sedang sakit dan dalam pemantauan.',
            ]
        );

        $dormitorySamples = [
            '2026001' => 'Putra A-01',
            '2026003' => 'Putra A-02',
            '2026005' => 'Putra A-03',
            '2026002' => 'Putri B-01',
        ];

        foreach ($dormitorySamples as $nis => $room) {
            $student = $demoStudents->get($nis);

            Dormitory::firstOrCreate(
                ['student_id' => $student->id],
                [
                    'nama_kamar' => $room,
                    'kapasitas' => 8,
                    'keterangan' => 'Penempatan contoh untuk pengujian modul asrama.',
                ]
            );
        }

        $linkedStudent = $demoStudents->get('2026001');

        if ($linkedStudent) {
            $parentUser->students()->syncWithoutDetaching([$linkedStudent->id => ['hubungan' => 'Ibu', 'status' => 'aktif']]);
        }

        $aisyah = $demoStudents->get('2026002');

        if ($aisyah) {
            $aisyahParent->students()->syncWithoutDetaching([$aisyah->id => ['hubungan' => 'Ayah', 'status' => 'aktif']]);
        }

        $fajar = $demoStudents->get('2026005');

        if ($fajar) {
            $fajarParent->students()->syncWithoutDetaching([$fajar->id => ['hubungan' => 'Ayah', 'status' => 'aktif']]);
        }

        $adminUser = User::where('email', 'admin@pesantren.test')->firstOrFail();
        $demoUsers = User::whereIn('email', [
            'admin@pesantren.test',
            'ustadz@pesantren.test',
            'santri@pesantren.test',
            'orangtua@pesantren.test',
            'wali.aisyah@pesantren.test',
            'wali.fajar@pesantren.test',
        ])->get();

        foreach ($demoUsers as $index => $user) {
            $this->seedImageAttachment(
                $user,
                'demo-avatar-user-'.$user->id.'.png',
                $user,
                'avatar',
                $this->demoColors($index)
            );
        }

        foreach ($demoStudents as $index => $student) {
            $this->seedImageAttachment(
                $student,
                'demo-avatar-student-'.$student->nis.'.png',
                $adminUser,
                'avatar',
                $this->demoColors($index + 2)
            );
        }

        foreach ([$ipa, $ips] as $index => $major) {
            $this->seedImageAttachment(
                $major,
                'demo-major-'.$major->kode.'.png',
                $adminUser,
                'catalog',
                $this->demoColors($index + 1)
            );
        }

        foreach ([$kelas7, $kelas8] as $index => $schoolClass) {
            $this->seedImageAttachment(
                $schoolClass,
                'demo-class-'.$schoolClass->nama.'.png',
                $adminUser,
                'catalog',
                $this->demoColors($index + 3)
            );
        }

        $firstStudent = $demoStudents->get('2026001');

        $demoRecords = [
            Attendance::where('student_id', $firstStudent->id)->latest('tanggal')->first(),
            Grade::where('student_id', $firstStudent->id)->first(),
            Bill::where('student_id', $firstStudent->id)->latest('tanggal_jatuh_tempo')->first(),
            HealthRecord::where('student_id', $firstStudent->id)->latest('tanggal_pemeriksaan')->first(),
            Dormitory::where('student_id', $firstStudent->id)->first(),
        ];

        foreach ($demoRecords as $index => $record) {
            if ($record) {
                $this->seedImageAttachment(
                    $record,
                    'demo-document-'.$record->getTable().'-'.$record->id.'.png',
                    $adminUser,
                    'document',
                    $this->demoColors($index + 1)
                );
            }
        }

        $this->call(InstitutionProfileSeeder::class);

        $this->call(InstitutionProfileSeeder::class);
    }

    private function seedImageAttachment(Model $imageable, string $filename, User $uploader, string $style, array $accent): void
    {
        $attachment = $imageable->imageAttachments()->where('original_name', $filename)->first();

        if ($attachment && Storage::disk($attachment->disk)->exists($attachment->path)) {
            return;
        }

        $path = $attachment?->path ?? 'images/demo/'.$filename;
        $contents = $this->renderDemoPng($style, $accent);
        Storage::disk('local')->put($path, $contents);

        $metadata = [
            'uploaded_by' => $uploader->id,
            'disk' => 'local',
            'path' => $path,
            'original_name' => $filename,
            'mime_type' => 'image/png',
            'size' => strlen($contents),
        ];

        if ($attachment) {
            $attachment->update($metadata);
        } else {
            $imageable->imageAttachments()->create($metadata);
        }
    }

    private function renderDemoPng(string $style, array $accent): string
    {
        $image = imagecreatetruecolor(480, 360);
        imageantialias($image, true);

        $background = imagecolorallocate($image, 241, 245, 249);
        $foreground = imagecolorallocate($image, ...$accent);
        $secondary = imagecolorallocate($image, 255, 255, 255);
        $skinTone = imagecolorallocate($image, 221, 185, 153);
        $ink = imagecolorallocate($image, 71, 85, 105);
        imagefill($image, 0, 0, $background);

        if ($style === 'avatar') {
            imagefilledellipse($image, 240, 430, 310, 260, $foreground);
            imagefilledrectangle($image, 215, 205, 265, 270, $skinTone);
            imagefilledellipse($image, 240, 155, 112, 132, $skinTone);
            imagefilledellipse($image, 240, 343, 174, 178, $foreground);
        } elseif ($style === 'catalog') {
            imagefilledellipse($image, 345, 120, 210, 210, $foreground);
            imagefilledrectangle($image, 48, 65, 245, 90, $ink);
            imagefilledrectangle($image, 48, 122, 275, 140, $foreground);
            imagefilledrectangle($image, 48, 164, 220, 182, $ink);
            imagefilledrectangle($image, 48, 206, 300, 224, $foreground);
            imagefilledrectangle($image, 48, 265, 426, 310, $secondary);
        } else {
            imagefilledrectangle($image, 90, 34, 390, 326, $secondary);
            imagefilledrectangle($image, 125, 70, 345, 92, $foreground);
            imagefilledrectangle($image, 125, 127, 345, 139, $ink);
            imagefilledrectangle($image, 125, 160, 315, 172, $ink);
            imagefilledrectangle($image, 125, 193, 345, 205, $ink);
            imagefilledrectangle($image, 125, 226, 290, 238, $ink);
            imagefilledrectangle($image, 275, 263, 345, 298, $foreground);
        }

        ob_start();
        imagepng($image);
        $contents = ob_get_clean();
        imagedestroy($image);

        return $contents;
    }

    private function demoColors(int $index): array
    {
        $palette = [
            [15, 118, 110],
            [217, 119, 6],
            [2, 132, 199],
            [190, 24, 93],
            [79, 70, 229],
            [5, 150, 105],
        ];

        return $palette[$index % count($palette)];
    }
}
