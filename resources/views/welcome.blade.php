<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Sistem informasi pesantren modern untuk pengelolaan santri, akademik, keuangan, kesehatan, dan asrama.">
        <title>Sekolah Islam Terpadu At-Tauhid | Sistem Informasi</title>
        <link rel="icon" type="image/png" href="{{ asset('images/LogoAttauhid.png') }}">

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="bg-white text-slate-800 antialiased">
        <header class="border-b border-slate-200 bg-white">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/LogoAttauhid.png') }}" alt="Logo Sekolah Islam Terpadu At-Tauhid" class="h-12 w-36 rounded-md border border-slate-200 bg-white object-cover shadow-sm" />
                </div>

                <nav class="hidden items-center gap-6 text-sm font-medium text-slate-700 md:flex">
                    <a href="#beranda" class="hover:text-emerald-700">Beranda</a>
                    <a href="{{ route('profil') }}" class="hover:text-emerald-700">Profil</a>
                    <a href="#program" class="hover:text-emerald-700">Program</a>
                    <a href="#berita" class="hover:text-emerald-700">Berita</a>
                    <a href="#kontak" class="hover:text-emerald-700">Kontak</a>
                </nav>

                <div class="flex items-center gap-3">
                    <a href="{{ route('login') }}" class="rounded-full border border-emerald-200 px-4 py-2 text-sm font-semibold text-emerald-700 hover:bg-emerald-50">
                        Login
                    </a>
                    <a href="#pendaftaran" class="rounded-full bg-emerald-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-emerald-700">
                        Daftar
                    </a>
                </div>
            </div>
        </header>

        <main>
            <section id="beranda" class="site-hero-background text-white">
                <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 sm:py-20 lg:px-8 lg:py-24">
                <div class="grid items-center gap-10 lg:grid-cols-[1.2fr_0.8fr]">
                    <div>
                        <span class="inline-flex rounded-md border border-white/25 bg-white/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.18em] text-emerald-50">
                            Pendidikan Islam Terpadu
                        </span>
                        <h2 class="mt-6 text-4xl font-black tracking-tight text-white sm:text-5xl">
                            Sekolah Islam Terpadu At-Tauhid
                        </h2>
                        <p class="mt-5 max-w-xl text-lg leading-8 text-emerald-50">
                            Membentuk generasi berilmu, berakhlak, dan dekat dengan Al-Qur'an melalui pendidikan terpadu serta pembinaan yang berkesinambungan.
                        </p>
                        <div class="mt-8 flex flex-wrap gap-4">
                            <a href="#pendaftaran" class="rounded-md bg-white px-6 py-3 text-sm font-semibold text-emerald-950 shadow-lg shadow-black/20 hover:bg-emerald-50">
                                Pendaftaran Santri Baru
                            </a>
                            <a href="{{ route('login') }}" class="rounded-md border border-white/30 bg-white/10 px-6 py-3 text-sm font-semibold text-white hover:bg-white/20">
                                Login Pengguna
                            </a>
                        </div>

                        <div class="mt-10 grid gap-4 sm:grid-cols-3">
                            <div class="rounded-md border border-white/20 bg-white/10 p-4 backdrop-blur-sm">
                                <p class="text-sm font-bold text-white">Akademik</p>
                                <p class="mt-1 text-sm text-emerald-50">Ilmu dan pembelajaran</p>
                            </div>
                            <div class="rounded-md border border-white/20 bg-white/10 p-4 backdrop-blur-sm">
                                <p class="text-sm font-bold text-amber-200">Tahfiz</p>
                                <p class="mt-1 text-sm text-emerald-50">Hafalan dan murajaah</p>
                            </div>
                            <div class="rounded-md border border-white/20 bg-white/10 p-4 backdrop-blur-sm">
                                <p class="text-sm font-bold text-sky-200">Pembinaan</p>
                                <p class="mt-1 text-sm text-emerald-50">Karakter dan kemandirian</p>
                            </div>
                        </div>
                    </div>

                    <div class="lg:pl-8">
                        <img src="{{ asset('images/LogoAttauhid.png') }}" alt="Sekolah Islam Terpadu At-Tauhid" class="mx-auto w-full max-w-[360px] rounded-lg border border-white/30 bg-white shadow-2xl shadow-black/30" />
                    </div>
                </div>
                </div>
            </section>

            <section id="program" class="scroll-mt-6 bg-slate-50 py-16 text-slate-900">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                        <div>
                            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-emerald-700">Program Inti</p>
                            <h3 class="mt-3 text-3xl font-black text-slate-900">Pendidikan dan pendampingan santri secara menyeluruh.</h3>
                        </div>
                        <a href="#pendaftaran" class="inline-flex rounded-md border border-emerald-200 bg-white px-5 py-3 text-sm font-semibold text-emerald-800 hover:bg-emerald-50">
                            Informasi pendaftaran
                        </a>
                    </div>

                    <div class="mt-10 grid gap-x-8 gap-y-0 md:grid-cols-2 xl:grid-cols-3">
                        <div class="border-t-2 border-emerald-600 py-6">
                            <p class="text-sm font-semibold text-emerald-700">01 / Akademik</p>
                            <h4 class="mt-2 text-xl font-bold">Kelas & pembelajaran</h4>
                            <p class="mt-2 text-sm leading-6 text-slate-600">Kegiatan belajar, kehadiran, evaluasi, dan perkembangan nilai santri.</p>
                        </div>
                        <div class="border-t-2 border-amber-500 py-6">
                            <p class="text-sm font-semibold text-amber-700">02 / Al-Qur'an</p>
                            <h4 class="mt-3 text-xl font-bold">Target hafalan</h4>
                            <p class="mt-2 text-sm leading-6 text-slate-600">Setoran, murajaah, dan pemantauan kemajuan tahfiz.</p>
                        </div>
                        <div class="border-t-2 border-sky-600 py-6">
                            <p class="text-sm font-semibold text-sky-700">03 / Pembinaan</p>
                            <h4 class="mt-3 text-xl font-bold">Ibadah & akhlak</h4>
                            <p class="mt-2 text-sm leading-6 text-slate-600">Pembiasaan ibadah, adab, disiplin, dan tanggung jawab.</p>
                        </div>
                        <div class="border-t-2 border-rose-500 py-6">
                            <p class="text-sm font-semibold text-rose-700">04 / Kehidupan santri</p>
                            <h4 class="mt-3 text-xl font-bold">Asrama & kemandirian</h4>
                            <p class="mt-2 text-sm leading-6 text-slate-600">Pendampingan keseharian, pengelolaan kamar, dan perizinan.</p>
                        </div>
                        <div class="border-t-2 border-cyan-600 py-6">
                            <p class="text-sm font-semibold text-cyan-800">05 / Kesejahteraan</p>
                            <h4 class="mt-3 text-xl font-bold">Perawatan</h4>
                            <p class="mt-2 text-sm leading-6 text-slate-600">Pencatatan kesehatan, tindak lanjut perawatan, dan pemantauan.</p>
                        </div>
                        <div class="border-t-2 border-violet-600 py-6">
                            <p class="text-sm font-semibold text-violet-800">06 / Kemitraan</p>
                            <h4 class="mt-3 text-xl font-bold">Kolaborasi orang tua</h4>
                            <p class="mt-2 text-sm leading-6 text-slate-600">Pemantauan perkembangan dan komunikasi keluarga dengan pesantren.</p>
                        </div>
                    </div>
                </div>
            </section>

            <section id="berita" class="bg-emerald-50 py-16">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="flex items-end justify-between gap-4">
                        <div>
                            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-emerald-700">Berita & agenda</p>
                            <h3 class="mt-3 text-3xl font-black text-slate-900">Informasi terbaru dan kegiatan pesantren</h3>
                        </div>
                    </div>

                    <div class="mt-10 grid gap-6 lg:grid-cols-3">
                        <article class="overflow-hidden rounded-lg border border-emerald-100 bg-white shadow-sm">
                            <div class="h-44 bg-gradient-to-br from-emerald-200 via-green-100 to-amber-100"></div>
                            <div class="p-5">
                                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-emerald-700">Agenda</p>
                                <h4 class="mt-3 text-xl font-bold text-slate-900">Kegiatan pembinaan akhlak mingguan</h4>
                                <p class="mt-3 text-sm text-slate-600">Agenda simulasi untuk membangun kehidupan santri yang disiplin, bersahaja, dan peduli lingkungan.</p>
                            </div>
                        </article>
                        <article class="overflow-hidden rounded-lg border border-emerald-100 bg-white shadow-sm">
                            <div class="h-44 bg-gradient-to-br from-amber-100 via-yellow-50 to-emerald-50"></div>
                            <div class="p-5">
                                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-amber-600">Berita</p>
                                <h4 class="mt-3 text-xl font-bold text-slate-900">Pekan literasi pesantren dimulai</h4>
                                <p class="mt-3 text-sm text-slate-600">Program membaca kitab, seminar, dan penulisan jurnal untuk menumbuhkan budaya ilmiah santri.</p>
                            </div>
                        </article>
                        <article class="overflow-hidden rounded-lg border border-emerald-100 bg-white shadow-sm">
                            <div class="h-44 bg-gradient-to-br from-sky-100 via-emerald-50 to-white"></div>
                            <div class="p-5">
                                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-sky-700">Pengumuman</p>
                                <h4 class="mt-3 text-xl font-bold text-slate-900">Pendaftaran santri baru dibuka</h4>
                                <p class="mt-3 text-sm text-slate-600">Proses pendaftaran dapat diawasi secara online oleh orang tua dan pengurus melalui sistem yang aman.</p>
                            </div>
                        </article>
                    </div>
                </div>
            </section>

            <section id="pendaftaran" class="bg-white py-16">
                <div class="mx-auto max-w-5xl rounded-lg border border-emerald-200 bg-gradient-to-r from-emerald-600 to-emerald-700 p-8 text-white shadow-xl shadow-emerald-200/60 sm:p-12">
                    <div class="grid gap-8 md:grid-cols-[1.1fr_0.9fr] md:items-center">
                        <div>
                            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-emerald-100">Pendaftaran santri baru</p>
                            <h3 class="mt-3 text-3xl font-black">Masuk ke proses pendaftaran yang lebih tertib dan transparan.</h3>
                            <p class="mt-4 max-w-lg text-emerald-50">
                                Orang tua dapat mengisi formulir, memantau status verifikasi, dan mengikuti perkembangan proses penerimaan santri baru dengan lebih mudah.
                            </p>
                        </div>
                        <div class="rounded-3xl bg-white/10 p-5 backdrop-blur-sm">
                            <div class="space-y-4">
                                <div class="rounded-2xl bg-white/10 p-4">
                                    <p class="text-xs uppercase tracking-[0.2em] text-emerald-100">Nomor pendaftaran</p>
                                    <p class="mt-2 text-2xl font-bold">PSD-2026-0048</p>
                                </div>
                                <div class="rounded-2xl bg-white/10 p-4">
                                    <p class="text-xs uppercase tracking-[0.2em] text-emerald-100">Status saat ini</p>
                                    <p class="mt-2 text-xl font-semibold">Menunggu verifikasi pengurus</p>
                                </div>
                                <a href="{{ route('login') }}" class="inline-flex w-full items-center justify-center rounded-full bg-white px-5 py-3 text-sm font-bold text-emerald-700 hover:bg-emerald-50">
                                    Masuk ke portal pendaftaran
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <footer id="kontak" class="border-t border-slate-200 bg-white">
            <div class="mx-auto flex max-w-7xl flex-col gap-6 px-4 py-8 text-sm text-slate-600 sm:px-6 lg:flex-row lg:items-center lg:justify-between lg:px-8">
                <div>
                    <p class="font-semibold text-slate-800">Sekolah Islam Terpadu At-Tauhid</p>
                    <p class="mt-1">Website resmi dan sistem pendukung pengelolaan pesantren modern</p>
                </div>
                <div class="flex flex-wrap gap-5">
                    <a href="{{ route('profil') }}" class="hover:text-emerald-700">Profil</a>
                    <a href="#program" class="hover:text-emerald-700">Program</a>
                    <a href="#berita" class="hover:text-emerald-700">Berita</a>
                    <a href="{{ route('login') }}" class="hover:text-emerald-700">Login</a>
                </div>
            </div>
        </footer>
    </body>
</html>
