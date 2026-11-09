<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Panel administrasi Sekolah Islam Terpadu At-Tauhid untuk pengelolaan santri dan operasional pesantren.">
        <title>Sekolah Islam Terpadu At-Tauhid | Panel Administrasi</title>
        <link rel="icon" type="image/png" href="{{ asset('images/LogoAttauhid.png') }}">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-slate-100 text-slate-800 antialiased">
        <div class="min-h-screen bg-[radial-gradient(circle_at_top,_rgba(16,185,129,0.14),_rgba(255,255,255,0)_35%)]">
            <nav class="border-b border-slate-200 bg-white/80 shadow-sm backdrop-blur">
                <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/LogoAttauhid.png') }}" alt="Logo Sekolah Islam Terpadu At-Tauhid" class="h-12 w-36 rounded-md border border-slate-200 bg-white object-cover shadow-sm" />
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="hidden rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700 md:inline-flex">Online</span>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="rounded-full border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                            Logout
                        </a>
                    </div>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>
                </div>
            </nav>

            <main class="mx-auto max-w-7xl px-6 py-10">
                <section class="overflow-hidden rounded-[28px] border border-emerald-200 bg-gradient-to-br from-emerald-700 via-emerald-600 to-teal-600 p-8 text-white shadow-2xl shadow-emerald-100">
                    <div class="flex flex-col gap-8 lg:flex-row lg:items-end lg:justify-between">
                        <div class="max-w-2xl">
                            <p class="text-sm font-semibold uppercase tracking-[0.22em] text-emerald-100">Dashboard Institusi</p>
                            <h2 class="mt-3 text-3xl font-black sm:text-4xl">Sekolah Islam Terpadu At-Tauhid</h2>
                            <p class="mt-4 max-w-xl text-sm text-emerald-50 sm:text-base">
                                Selamat datang di pusat kendali pesantren digital untuk manajemen santri, pembelajaran, keuangan, kesehatan, asrama, dan operasional harian.
                            </p>
                        </div>
                        <div class="flex flex-wrap gap-3">
                            <span class="rounded-full border border-white/20 bg-white/10 px-3 py-1.5 text-xs font-semibold uppercase tracking-[0.18em] text-emerald-50">Aktif</span>
                            <span class="rounded-full border border-white/20 bg-white/10 px-3 py-1.5 text-xs font-semibold uppercase tracking-[0.18em] text-emerald-50">Q4 2026</span>
                        </div>
                    </div>
                </section>

                <section class="mt-8 grid gap-5 md:grid-cols-2 xl:grid-cols-4">
                    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Santri</span>
                            <span class="rounded-full bg-emerald-50 px-2 py-1 text-xs font-semibold text-emerald-700">+8%</span>
                        </div>
                        <p class="mt-4 text-3xl font-black text-slate-900">1.200</p>
                        <p class="mt-2 text-sm text-slate-500">Jumlah santri aktif</p>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Kehadiran</span>
                            <span class="rounded-full bg-amber-50 px-2 py-1 text-xs font-semibold text-amber-700">Hari ini</span>
                        </div>
                        <p class="mt-4 text-3xl font-black text-slate-900">94%</p>
                        <p class="mt-2 text-sm text-slate-500">Rata-rata kehadiran</p>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Tagihan</span>
                            <span class="rounded-full bg-rose-50 px-2 py-1 text-xs font-semibold text-rose-700">Belum bayar</span>
                        </div>
                        <p class="mt-4 text-3xl font-black text-slate-900">Rp 124M</p>
                        <p class="mt-2 text-sm text-slate-500">Total tunggakan</p>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Kesehatan</span>
                            <span class="rounded-full bg-sky-50 px-2 py-1 text-xs font-semibold text-sky-700">Rutin</span>
                        </div>
                        <p class="mt-4 text-3xl font-black text-slate-900">96%</p>
                        <p class="mt-2 text-sm text-slate-500">Status sehat terpantau</p>
                    </div>
                </section>

                <section class="mt-10">
                    <div class="mb-5 flex items-center justify-between">
                        <h3 class="text-2xl font-black text-slate-900">Modul Utama</h3>
                        <span class="text-sm font-medium text-slate-500">Semua fungsi operasional pusat</span>
                    </div>

                    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                        <a href="{{ route('admin.santri.index') }}" class="group rounded-2xl border border-emerald-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                            <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-100 text-lg font-bold text-emerald-700">S</div>
                            <h4 class="text-lg font-bold text-slate-900">Manajemen Santri</h4>
                            <p class="mt-2 text-sm text-slate-600">Data santri, status, dan informasi personal.</p>
                        </a>

                        <a href="{{ route('admin.master-data.index') }}" class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                            <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-slate-100 text-lg font-bold text-slate-700">M</div>
                            <h4 class="text-lg font-bold text-slate-900">Master Data</h4>
                            <p class="mt-2 text-sm text-slate-600">Kelas, jurusan, dan struktur pendidikan.</p>
                        </a>

                        <a href="{{ route('admin.kehadiran.index') }}" class="group rounded-2xl border border-amber-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                            <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-amber-100 text-lg font-bold text-amber-700">K</div>
                            <h4 class="text-lg font-bold text-slate-900">Kehadiran Santri</h4>
                            <p class="mt-2 text-sm text-slate-600">Absensi dan pencatatan aktivitas harian.</p>
                        </a>

                        <a href="{{ route('admin.akademik.index') }}" class="group rounded-2xl border border-violet-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                            <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-violet-100 text-lg font-bold text-violet-700">N</div>
                            <h4 class="text-lg font-bold text-slate-900">Nilai Akademik</h4>
                            <p class="mt-2 text-sm text-slate-600">Pencatatan hasil belajar dan evaluasi.</p>
                        </a>

                        <a href="{{ route('admin.tagihan.index') }}" class="group rounded-2xl border border-fuchsia-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                            <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-fuchsia-100 text-lg font-bold text-fuchsia-700">T</div>
                            <h4 class="text-lg font-bold text-slate-900">Tagihan Santri</h4>
                            <p class="mt-2 text-sm text-slate-600">Monitoring tunggakan, pembayaran, dan status.</p>
                        </a>

                        <a href="{{ route('admin.asrama.index') }}" class="group rounded-2xl border border-cyan-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                            <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-cyan-100 text-lg font-bold text-cyan-700">A</div>
                            <h4 class="text-lg font-bold text-slate-900">Asrama Santri</h4>
                            <p class="mt-2 text-sm text-slate-600">Penempatan kamar dan catatan pengelolaan asrama.</p>
                        </a>

                        <a href="{{ route('admin.kesehatan.index') }}" class="group rounded-2xl border border-rose-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                            <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-rose-100 text-lg font-bold text-rose-700">H</div>
                            <h4 class="text-lg font-bold text-slate-900">Kesehatan Santri</h4>
                            <p class="mt-2 text-sm text-slate-600">Pemeriksaan dan catatan kesehatan harian.</p>
                        </a>

                        <a href="{{ route('admin.laporan.index') }}" class="group rounded-2xl border border-indigo-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                            <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-100 text-lg font-bold text-indigo-700">L</div>
                            <h4 class="text-lg font-bold text-slate-900">Laporan & Ringkasan</h4>
                            <p class="mt-2 text-sm text-slate-600">Progress operasional dan indikator utama.</p>
                        </a>

                        <a href="{{ route('admin.users.index') }}" class="group rounded-2xl border border-sky-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                            <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-sky-100 text-lg font-bold text-sky-700">P</div>
                            <h4 class="text-lg font-bold text-slate-900">Manajemen Pengguna</h4>
                            <p class="mt-2 text-sm text-slate-600">Akses, role, dan pengelolaan akun internal.</p>
                        </a>

                        <a href="{{ route('admin.profil.index') }}" class="group rounded-2xl border border-emerald-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                            <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-100 text-lg font-bold text-emerald-700">I</div>
                            <h4 class="text-lg font-bold text-slate-900">Profil Pesantren</h4>
                            <p class="mt-2 text-sm text-slate-600">Kelola sejarah, visi, misi, struktur, dan program publik.</p>
                        </a>
                    </div>
                </section>
            </main>
        </div>
    </body>
</html>
