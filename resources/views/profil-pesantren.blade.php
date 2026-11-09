<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Profil, visi, misi, struktur organisasi, dan program inti Sekolah Islam Terpadu At-Tauhid.">
        <title>Profil Pesantren | Sekolah Islam Terpadu At-Tauhid</title>
        <link rel="icon" type="image/png" href="{{ asset('images/LogoAttauhid.png') }}">

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="bg-white text-slate-800 antialiased">
        <header class="border-b border-slate-200 bg-white">
            <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
                <a href="{{ url('/') }}" aria-label="Beranda At-Tauhid">
                    <img src="{{ asset('images/LogoAttauhid.png') }}" alt="Logo Sekolah Islam Terpadu At-Tauhid" class="h-12 w-36 rounded-md border border-slate-200 bg-white object-cover shadow-sm">
                </a>

                <nav aria-label="Navigasi utama" class="hidden items-center gap-6 text-sm font-medium text-slate-700 md:flex">
                    <a href="{{ url('/') }}" class="hover:text-emerald-700">Beranda</a>
                    <a href="{{ route('profil') }}" aria-current="page" class="font-bold text-emerald-800">Profil</a>
                    <a href="{{ url('/#program') }}" class="hover:text-emerald-700">Program</a>
                    <a href="{{ url('/#berita') }}" class="hover:text-emerald-700">Berita</a>
                    <a href="{{ url('/#kontak') }}" class="hover:text-emerald-700">Kontak</a>
                </nav>

                <div class="flex items-center gap-2 sm:gap-3">
                    <a href="{{ route('login') }}" class="rounded-md border border-emerald-200 px-3 py-2 text-sm font-semibold text-emerald-800 hover:bg-emerald-50 sm:px-4">Login</a>
                    <a href="{{ url('/#pendaftaran') }}" class="rounded-md bg-emerald-700 px-3 py-2 text-sm font-semibold text-white hover:bg-emerald-800 sm:px-4">Daftar</a>
                </div>
            </div>
        </header>

        <main>
            <section class="site-hero-background text-white">
                <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 sm:py-18 lg:px-8 lg:py-20">
                    <p class="text-sm font-semibold uppercase tracking-[0.18em] text-emerald-200">Profil Pesantren</p>
                    <h1 class="mt-3 max-w-4xl text-3xl font-black sm:text-4xl lg:text-5xl">Sekolah Islam Terpadu At-Tauhid</h1>
                    <p class="mt-5 max-w-3xl text-base leading-7 text-emerald-50 sm:text-lg">
                        Lingkungan pendidikan Islam yang memadukan ilmu, pembinaan akhlak, tahfiz Al-Qur'an, dan pendampingan kehidupan santri.
                    </p>

                    <nav aria-label="Navigasi bagian profil" class="mt-8 flex flex-wrap gap-2 rounded-md border border-white/20 bg-emerald-950/90 p-3 text-sm font-semibold shadow-lg backdrop-blur-md">
                        <a href="#sejarah" class="rounded px-3 py-2 text-white underline-offset-4 hover:bg-white/10 hover:underline focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-amber-300">Sejarah</a>
                        <a href="#visi-misi" class="rounded px-3 py-2 text-white underline-offset-4 hover:bg-white/10 hover:underline focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-amber-300">Visi & Misi</a>
                        <a href="#struktur" class="rounded px-3 py-2 text-white underline-offset-4 hover:bg-white/10 hover:underline focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-amber-300">Struktur Organisasi</a>
                        <a href="#program-inti" class="rounded px-3 py-2 text-white underline-offset-4 hover:bg-white/10 hover:underline focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-amber-300">Program Inti</a>
                    </nav>
                </div>
            </section>

            <section id="sejarah" class="scroll-mt-6 border-b border-slate-200 bg-white">
                <div class="mx-auto grid max-w-7xl gap-5 px-4 py-12 sm:px-6 md:grid-cols-[0.7fr_1.3fr] md:gap-12 lg:px-8 lg:py-16">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-emerald-700">01 / Perjalanan</p>
                        <h2 class="mt-2 text-2xl font-bold text-slate-900">Sejarah Pesantren</h2>
                    </div>
                    <div class="max-w-3xl space-y-4 text-sm leading-7 text-slate-600 sm:text-base">
                        <p>
                            At-Tauhid menyelenggarakan pendidikan Islam terpadu yang menghubungkan pembelajaran akademik, tahfiz Al-Qur'an, pembiasaan ibadah, dan pembinaan karakter dalam keseharian santri.
                        </p>
                        <p>
                            Pengelolaan pendidikan dan layanan santri dikembangkan agar proses belajar, kehidupan asrama, kesehatan, serta komunikasi dengan orang tua berjalan dalam satu pendampingan yang berkesinambungan.
                        </p>
                    </div>
                </div>
            </section>

            <section id="visi-misi" class="scroll-mt-6 border-b border-slate-200 bg-slate-50">
                <div class="mx-auto grid max-w-7xl gap-8 px-4 py-12 sm:px-6 md:grid-cols-2 md:gap-12 lg:px-8 lg:py-16">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-amber-700">Arah pendidikan</p>
                        <h2 class="mt-2 text-2xl font-bold text-slate-900">Visi</h2>
                        <p class="mt-4 max-w-xl text-lg leading-8 text-slate-700">
                            Terbentuknya generasi muslim yang berilmu, berakhlak mulia, mandiri, dan dekat dengan Al-Qur'an.
                        </p>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-slate-900">Misi</h2>
                        <ol class="mt-4 space-y-3 text-sm leading-6 text-slate-700 sm:text-base">
                            <li class="flex gap-3"><span class="font-bold text-amber-700">01</span><span>Menyelenggarakan pembelajaran akademik yang terarah dan bermutu.</span></li>
                            <li class="flex gap-3"><span class="font-bold text-amber-700">02</span><span>Menumbuhkan kecintaan terhadap Al-Qur'an melalui tahfiz dan murajaah.</span></li>
                            <li class="flex gap-3"><span class="font-bold text-amber-700">03</span><span>Membiasakan ibadah, adab, disiplin, dan kemandirian dalam kehidupan sehari-hari.</span></li>
                            <li class="flex gap-3"><span class="font-bold text-amber-700">04</span><span>Mendampingi perkembangan akademik, kesehatan, dan kesejahteraan santri bersama orang tua.</span></li>
                        </ol>
                    </div>
                </div>
            </section>

            <section id="struktur" class="scroll-mt-6 border-b border-slate-200 bg-white">
                <div class="mx-auto grid max-w-7xl gap-5 px-4 py-12 sm:px-6 md:grid-cols-[0.7fr_1.3fr] md:gap-12 lg:px-8 lg:py-16">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-sky-700">02 / Pengelolaan</p>
                        <h2 class="mt-2 text-2xl font-bold text-slate-900">Struktur Organisasi</h2>
                        <p class="mt-3 max-w-sm text-sm leading-6 text-slate-600">Bidang pengelolaan utama untuk mendukung pendidikan dan keseharian santri.</p>
                    </div>
                    <dl class="grid gap-x-8 gap-y-6 sm:grid-cols-2">
                        <div class="border-l-2 border-emerald-600 pl-4">
                            <dt class="font-bold text-slate-900">Pimpinan & Pengasuh</dt>
                            <dd class="mt-1 text-sm leading-6 text-slate-600">Arah pendidikan, pengasuhan, dan kebijakan pesantren.</dd>
                        </div>
                        <div class="border-l-2 border-amber-500 pl-4">
                            <dt class="font-bold text-slate-900">Pendidikan & Akademik</dt>
                            <dd class="mt-1 text-sm leading-6 text-slate-600">Kelas, pembelajaran, evaluasi, dan perkembangan akademik.</dd>
                        </div>
                        <div class="border-l-2 border-sky-600 pl-4">
                            <dt class="font-bold text-slate-900">Tahfiz & Pembinaan</dt>
                            <dd class="mt-1 text-sm leading-6 text-slate-600">Setoran hafalan, murajaah, ibadah, dan pembentukan akhlak.</dd>
                        </div>
                        <div class="border-l-2 border-rose-600 pl-4">
                            <dt class="font-bold text-slate-900">Kesantrian & Asrama</dt>
                            <dd class="mt-1 text-sm leading-6 text-slate-600">Kehidupan harian, kedisiplinan, kamar, dan perizinan santri.</dd>
                        </div>
                        <div class="border-l-2 border-cyan-700 pl-4">
                            <dt class="font-bold text-slate-900">Administrasi & Keuangan</dt>
                            <dd class="mt-1 text-sm leading-6 text-slate-600">Data, layanan administrasi, dan pengelolaan tagihan.</dd>
                        </div>
                        <div class="border-l-2 border-violet-700 pl-4">
                            <dt class="font-bold text-slate-900">Kesehatan & Kemitraan Orang Tua</dt>
                            <dd class="mt-1 text-sm leading-6 text-slate-600">Pemantauan kesehatan serta komunikasi perkembangan santri.</dd>
                        </div>
                    </dl>
                </div>
            </section>

            <section id="program-inti" class="scroll-mt-6 bg-slate-50">
                <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8 lg:py-16">
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-emerald-700">03 / Pendidikan & layanan</p>
                    <h2 class="mt-2 text-2xl font-bold text-slate-900">Program Inti</h2>
                    <div class="mt-8 grid gap-x-8 md:grid-cols-2 xl:grid-cols-3">
                        <article class="border-t-2 border-emerald-600 py-6">
                            <p class="text-sm font-semibold text-emerald-700">01 / Akademik</p>
                            <h3 class="mt-2 text-xl font-bold">Kelas & pembelajaran</h3>
                            <p class="mt-2 text-sm leading-6 text-slate-600">Kegiatan belajar, kehadiran, evaluasi, dan perkembangan nilai santri.</p>
                        </article>
                        <article class="border-t-2 border-amber-500 py-6">
                            <p class="text-sm font-semibold text-amber-700">02 / Al-Qur'an</p>
                            <h3 class="mt-2 text-xl font-bold">Tahfiz & murajaah</h3>
                            <p class="mt-2 text-sm leading-6 text-slate-600">Setoran hafalan, pengulangan, dan pemantauan kemajuan tahfiz.</p>
                        </article>
                        <article class="border-t-2 border-sky-600 py-6">
                            <p class="text-sm font-semibold text-sky-700">03 / Pembinaan</p>
                            <h3 class="mt-2 text-xl font-bold">Ibadah & akhlak</h3>
                            <p class="mt-2 text-sm leading-6 text-slate-600">Pembiasaan ibadah, adab, disiplin, dan tanggung jawab.</p>
                        </article>
                        <article class="border-t-2 border-rose-500 py-6">
                            <p class="text-sm font-semibold text-rose-700">04 / Kehidupan santri</p>
                            <h3 class="mt-2 text-xl font-bold">Asrama & kemandirian</h3>
                            <p class="mt-2 text-sm leading-6 text-slate-600">Pendampingan keseharian, pengelolaan kamar, dan perizinan.</p>
                        </article>
                        <article class="border-t-2 border-cyan-600 py-6">
                            <p class="text-sm font-semibold text-cyan-800">05 / Kesejahteraan</p>
                            <h3 class="mt-2 text-xl font-bold">Kesehatan & perawatan</h3>
                            <p class="mt-2 text-sm leading-6 text-slate-600">Pencatatan kesehatan, tindak lanjut perawatan, dan pemantauan.</p>
                        </article>
                        <article class="border-t-2 border-violet-600 py-6">
                            <p class="text-sm font-semibold text-violet-800">06 / Kemitraan</p>
                            <h3 class="mt-2 text-xl font-bold">Kolaborasi orang tua</h3>
                            <p class="mt-2 text-sm leading-6 text-slate-600">Pemantauan perkembangan dan komunikasi keluarga dengan pesantren.</p>
                        </article>
                    </div>
                </div>
            </section>
        </main>

        <footer class="border-t border-slate-200 bg-white">
            <div class="mx-auto flex max-w-7xl flex-col gap-5 px-4 py-8 text-sm text-slate-600 sm:px-6 md:flex-row md:items-center md:justify-between lg:px-8">
                <div>
                    <p class="font-semibold text-slate-800">Sekolah Islam Terpadu At-Tauhid</p>
                    <p class="mt-1">Profil lembaga pendidikan dan pesantren</p>
                </div>
                <div class="flex flex-wrap gap-5">
                    <a href="{{ url('/') }}" class="hover:text-emerald-700">Beranda</a>
                    <a href="{{ route('login') }}" class="hover:text-emerald-700">Login</a>
                    <a href="{{ url('/#kontak') }}" class="hover:text-emerald-700">Kontak</a>
                </div>
            </div>
        </footer>
    </body>
</html>