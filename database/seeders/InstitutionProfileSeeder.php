<?php

namespace Database\Seeders;

use App\Models\InstitutionProfileSection;
use Illuminate\Database\Seeder;

class InstitutionProfileSeeder extends Seeder
{
    public function run(): void
    {
        $sections = [
            [
                'section_type' => 'history',
                'slug' => 'sejarah-pesantren',
                'title' => 'Sejarah Pesantren',
                'content' => 'At-Tauhid menyelenggarakan pendidikan Islam terpadu yang menghubungkan pembelajaran akademik, tahfiz Al-Qur\'an, pembiasaan ibadah, dan pembinaan karakter dalam keseharian santri.\n\nPengelolaan pendidikan dan layanan santri dikembangkan agar proses belajar, kehidupan asrama, kesehatan, serta komunikasi dengan orang tua berjalan dalam satu pendampingan yang berkesinambungan.',
                'sort_order' => 1,
            ],
            [
                'section_type' => 'vision',
                'slug' => 'visi-pesantren',
                'title' => 'Visi',
                'content' => 'Terbentuknya generasi muslim yang berilmu, berakhlak mulia, mandiri, dan dekat dengan Al-Qur\'an.',
                'sort_order' => 1,
            ],
            [
                'section_type' => 'mission',
                'slug' => 'misi-pembelajaran',
                'title' => 'Pembelajaran akademik',
                'content' => 'Menyelenggarakan pembelajaran akademik yang terarah dan bermutu.',
                'sort_order' => 1,
            ],
            [
                'section_type' => 'mission',
                'slug' => 'misi-al-quran',
                'title' => 'Al-Qur\'an dan tahfiz',
                'content' => 'Menumbuhkan kecintaan terhadap Al-Qur\'an melalui tahfiz dan murajaah.',
                'sort_order' => 2,
            ],
            [
                'section_type' => 'mission',
                'slug' => 'misi-pembinaan',
                'title' => 'Ibadah dan akhlak',
                'content' => 'Membiasakan ibadah, adab, disiplin, dan kemandirian dalam kehidupan sehari-hari.',
                'sort_order' => 3,
            ],
            [
                'section_type' => 'mission',
                'slug' => 'misi-pendampingan',
                'title' => 'Pendampingan santri',
                'content' => 'Mendampingi perkembangan akademik, kesehatan, dan kesejahteraan santri bersama orang tua.',
                'sort_order' => 4,
            ],
            [
                'section_type' => 'organization',
                'slug' => 'struktur-pimpinan-pengasuh',
                'title' => 'Pimpinan & Pengasuh',
                'content' => 'Arah pendidikan, pengasuhan, dan kebijakan pesantren.',
                'sort_order' => 1,
            ],
            [
                'section_type' => 'organization',
                'slug' => 'struktur-pendidikan-akademik',
                'title' => 'Pendidikan & Akademik',
                'content' => 'Kelas, pembelajaran, evaluasi, dan perkembangan akademik.',
                'sort_order' => 2,
            ],
            [
                'section_type' => 'organization',
                'slug' => 'struktur-tahfiz-pembinaan',
                'title' => 'Tahfiz & Pembinaan',
                'content' => 'Setoran hafalan, murajaah, ibadah, dan pembentukan akhlak.',
                'sort_order' => 3,
            ],
            [
                'section_type' => 'organization',
                'slug' => 'struktur-kesantrian-asrama',
                'title' => 'Kesantrian & Asrama',
                'content' => 'Kehidupan harian, kedisiplinan, kamar, dan perizinan santri.',
                'sort_order' => 4,
            ],
            [
                'section_type' => 'organization',
                'slug' => 'struktur-administrasi-keuangan',
                'title' => 'Administrasi & Keuangan',
                'content' => 'Data, layanan administrasi, dan pengelolaan tagihan.',
                'sort_order' => 5,
            ],
            [
                'section_type' => 'organization',
                'slug' => 'struktur-kesehatan-kemitraan',
                'title' => 'Kesehatan & Kemitraan Orang Tua',
                'content' => 'Pemantauan kesehatan serta komunikasi perkembangan santri.',
                'sort_order' => 6,
            ],
            [
                'section_type' => 'program',
                'slug' => 'program-akademik',
                'title' => 'Kelas & pembelajaran',
                'content' => 'Kegiatan belajar, kehadiran, evaluasi, dan perkembangan nilai santri.',
                'sort_order' => 1,
            ],
            [
                'section_type' => 'program',
                'slug' => 'program-tahfiz',
                'title' => 'Tahfiz & murajaah',
                'content' => 'Setoran hafalan, pengulangan, dan pemantauan kemajuan tahfiz.',
                'sort_order' => 2,
            ],
            [
                'section_type' => 'program',
                'slug' => 'program-ibadah-akhlak',
                'title' => 'Ibadah & akhlak',
                'content' => 'Pembiasaan ibadah, adab, disiplin, dan tanggung jawab.',
                'sort_order' => 3,
            ],
            [
                'section_type' => 'program',
                'slug' => 'program-asrama',
                'title' => 'Asrama & kemandirian',
                'content' => 'Pendampingan keseharian, pengelolaan kamar, dan perizinan.',
                'sort_order' => 4,
            ],
            [
                'section_type' => 'program',
                'slug' => 'program-kesehatan',
                'title' => 'Kesehatan & perawatan',
                'content' => 'Pencatatan kesehatan, tindak lanjut perawatan, dan pemantauan.',
                'sort_order' => 5,
            ],
            [
                'section_type' => 'program',
                'slug' => 'program-kemitraan-orang-tua',
                'title' => 'Kolaborasi orang tua',
                'content' => 'Pemantauan perkembangan dan komunikasi keluarga dengan pesantren.',
                'sort_order' => 6,
            ],
        ];

        foreach ($sections as $section) {
            InstitutionProfileSection::firstOrCreate(
                ['slug' => $section['slug']],
                [...$section, 'is_published' => true]
            );
        }
    }
}