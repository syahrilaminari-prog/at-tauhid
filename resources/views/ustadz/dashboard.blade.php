<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sekolah Islam Terpadu At-Tauhid | Dashboard Ustadz</title>
        <link rel="icon" type="image/png" href="{{ asset('images/LogoAttauhid.png') }}">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-violet-50 text-slate-800 antialiased">
        <div class="min-h-screen">
            <nav class="border-b border-violet-200 bg-white/90 shadow-sm backdrop-blur">
                <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/LogoAttauhid.png') }}" alt="Logo Sekolah Islam Terpadu At-Tauhid" class="h-12 w-36 rounded-md border border-slate-200 bg-white object-cover shadow-sm" />
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="rounded-full bg-violet-100 px-3 py-1 text-xs font-semibold text-violet-700">Dashboard Ustadz</span>
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
                <section class="overflow-hidden rounded-[28px] bg-gradient-to-br from-violet-700 via-indigo-600 to-blue-600 p-8 text-white shadow-xl shadow-violet-200">
                    <p class="text-sm font-semibold uppercase tracking-[0.22em] text-violet-100">Monitoring pembelajaran</p>
                    <h2 class="mt-3 text-3xl font-black">{{ Auth::user()->name ?? 'Ustadz' }}</h2>
                    <p class="mt-4 max-w-2xl text-sm text-violet-50">
                        Dashboard ini memantau kelas, kehadiran santri, nilai akademik, dan perkembangan pembelajaran yang menjadi tanggung jawab ustadz.
                    </p>
                </section>

                <section class="mt-8 grid gap-5 md:grid-cols-2 xl:grid-cols-4">
                    <div class="rounded-2xl border border-violet-200 bg-white p-5 shadow-sm">
                        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Kelas</p>
                        <p class="mt-4 text-3xl font-black text-slate-900">6</p>
                        <p class="mt-2 text-sm text-slate-500">Jumlah kelas aktif</p>
                    </div>
                    <div class="rounded-2xl border border-violet-200 bg-white p-5 shadow-sm">
                        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Absensi</p>
                        <p class="mt-4 text-3xl font-black text-slate-900">94%</p>
                        <p class="mt-2 text-sm text-slate-500">Kehadiran keseluruhan</p>
                    </div>
                    <div class="rounded-2xl border border-violet-200 bg-white p-5 shadow-sm">
                        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Nilai</p>
                        <p class="mt-4 text-3xl font-black text-slate-900">87</p>
                        <p class="mt-2 text-sm text-slate-500">Rata-rata kelas</p>
                    </div>
                    <div class="rounded-2xl border border-violet-200 bg-white p-5 shadow-sm">
                        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Catatan</p>
                        <p class="mt-4 text-3xl font-black text-slate-900">12</p>
                        <p class="mt-2 text-sm text-slate-500">Catatan pembinaan</p>
                    </div>
                </section>

                <section class="mt-10 grid gap-6 lg:grid-cols-3">
                    <div class="rounded-2xl border border-violet-200 bg-white p-5 shadow-sm">
                        <h3 class="text-lg font-black text-slate-900">Agenda hari ini</h3>
                        <ul class="mt-4 space-y-3 text-sm text-slate-600">
                            <li>• Tahsin pagi pukul 06:30</li>
                            <li>• Pelajaran Fiqih kelas VII</li>
                            <li>• Evaluasi hafalan santri</li>
                        </ul>
                    </div>
                    <div class="rounded-2xl border border-violet-200 bg-white p-5 shadow-sm">
                        <h3 class="text-lg font-black text-slate-900">Santri perlu perhatian</h3>
                        <ul class="mt-4 space-y-3 text-sm text-slate-600">
                            <li>• 3 santri belum masuk tepat waktu</li>
                            <li>• 2 catatan nilai belum diinput</li>
                            <li>• 1 santri butuh pembinaan ekstra</li>
                        </ul>
                    </div>
                    <div class="rounded-2xl border border-violet-200 bg-white p-5 shadow-sm">
                        <h3 class="text-lg font-black text-slate-900">Target pembelajaran</h3>
                        <ul class="mt-4 space-y-3 text-sm text-slate-600">
                            <li>• Hafalan target: 5 juz</li>
                            <li>• Kehadiran minimal 90%</li>
                            <li>• Rata-rata nilai ≥ 80</li>
                        </ul>
                    </div>
                </section>
            </main>
        </div>
    </body>
</html>
