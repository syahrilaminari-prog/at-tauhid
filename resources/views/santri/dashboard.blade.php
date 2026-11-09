<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sekolah Islam Terpadu At-Tauhid | Dashboard Santri</title>
        <link rel="icon" type="image/png" href="{{ asset('images/LogoAttauhid.png') }}">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-emerald-50 text-slate-800 antialiased">
        <div class="min-h-screen">
            <nav class="border-b border-emerald-200 bg-white/80 shadow-sm backdrop-blur">
                <div class="mx-auto flex max-w-6xl items-center justify-between px-6 py-4">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/LogoAttauhid.png') }}" alt="Logo Sekolah Islam Terpadu At-Tauhid" class="h-12 w-36 rounded-md border border-slate-200 bg-white object-cover shadow-sm" />
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">Dashboard Santri</span>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="rounded-full border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                            Logout
                        </a>
                    </div>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>
                </div>
            </nav>

            <main class="mx-auto max-w-6xl px-6 py-10">
                <section class="overflow-hidden rounded-[28px] bg-gradient-to-br from-emerald-600 via-teal-600 to-cyan-600 p-8 text-white shadow-xl shadow-emerald-200">
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-emerald-100">Selamat datang</p>
                    <h2 class="mt-3 text-3xl font-black">{{ Auth::user()->name ?? 'Santri' }}</h2>
                    <p class="mt-3 max-w-2xl text-sm text-emerald-50">
                        Ini adalah halaman dashboard santri untuk melihat informasi kegiatan, nilai, absensi, dan perkembangan pembelajaran Anda.
                    </p>
                </section>

                <section class="mt-8 grid gap-5 md:grid-cols-3">
                    <div class="rounded-2xl border border-emerald-200 bg-white p-5 shadow-sm">
                        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Kehadiran</p>
                        <p class="mt-4 text-3xl font-black text-slate-900">96%</p>
                        <p class="mt-2 text-sm text-slate-500">Rata-rata kehadiran bulan ini</p>
                    </div>
                    <div class="rounded-2xl border border-emerald-200 bg-white p-5 shadow-sm">
                        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Nilai</p>
                        <p class="mt-4 text-3xl font-black text-slate-900">A</p>
                        <p class="mt-2 text-sm text-slate-500">Rata-rata akademik saat ini</p>
                    </div>
                    <div class="rounded-2xl border border-emerald-200 bg-white p-5 shadow-sm">
                        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Tagihan</p>
                        <p class="mt-4 text-3xl font-black text-slate-900">Rp 550K</p>
                        <p class="mt-2 text-sm text-slate-500">Status tagihan bulan ini</p>
                    </div>
                </section>
            </main>
        </div>
    </body>
</html>
