<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laporan & Dashboard Ringkasan</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="module-shell">
        <div class="min-h-screen">
            <nav class="border-b border-slate-200 bg-white/80 shadow-sm backdrop-blur">
                <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-indigo-700">SIM</p>
                        <h1 class="text-xl font-bold text-slate-900">Laporan & Dashboard Ringkasan</h1>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('admin.dashboard') }}" class="rounded-full border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                            Dashboard
                        </a>
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
                <div class="mb-8 rounded-3xl border border-indigo-200 bg-gradient-to-r from-indigo-600 to-violet-600 p-8 text-white shadow-xl shadow-indigo-100">
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-indigo-100">Laporan</p>
                    <h2 class="mt-3 text-3xl font-black">Ringkasan Operasional</h2>
                    <p class="mt-3 max-w-2xl text-indigo-50">Ikhtisar terbaru terkait santri, kehadiran, akademik, tagihan, dan kesehatan pesantren.</p>
                </div>

                <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
                    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Total Santri</p>
                        <p class="mt-3 text-3xl font-black text-slate-900">{{ $totalSantri }}</p>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Kehadiran Hari Ini</p>
                        <p class="mt-3 text-3xl font-black text-slate-900">{{ $totalKehadiranHariIni }}</p>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Tagihan Belum Bayar</p>
                        <p class="mt-3 text-3xl font-black text-slate-900">{{ $totalTagihanBelumBayar }}</p>
                        <p class="mt-2 text-sm text-slate-500">Rp {{ number_format($totalTagihanNominalBelumBayar, 0, ',', '.') }}</p>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Kesehatan</p>
                        <p class="mt-3 text-3xl font-black text-slate-900">{{ $persentaseKehadiran }}%</p>
                        <p class="mt-2 text-sm text-slate-500">{{ $totalKesehatanCatatan }} catatan kesehatan</p>
                    </div>
                </div>

                <div class="mt-8 grid gap-6 lg:grid-cols-2">
                    <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="flex items-center justify-between">
                            <h3 class="text-xl font-bold text-slate-900">Kondisi Kesehatan</h3>
                            <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">Ringkasan</span>
                        </div>
                        <div class="mt-5 space-y-3">
                            @forelse ($kondisiKesehatan as $item)
                                <div class="flex items-center justify-between rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3">
                                    <span class="font-medium text-slate-700">{{ $item->status_kesehatan }}</span>
                                    <span class="rounded-full bg-indigo-100 px-2.5 py-1 text-xs font-semibold text-indigo-700">{{ $item->total }}</span>
                                </div>
                            @empty
                                <p class="text-sm text-slate-500">Belum ada catatan kesehatan.</p>
                            @endforelse
                        </div>
                    </section>

                    <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <h3 class="text-xl font-bold text-slate-900">Kehadiran Terbaru</h3>
                        <div class="mt-5 space-y-3">
                            @forelse ($recentAttendance as $attendance)
                                <div class="flex items-center justify-between rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3">
                                    <div>
                                        <p class="font-semibold text-slate-900">{{ $attendance->student?->nama ?? 'Santri' }}</p>
                                        <p class="text-sm text-slate-500">{{ $attendance->tanggal }}</p>
                                    </div>
                                    <span class="rounded-full px-3 py-1 text-xs font-semibold
                                        @if($attendance->status === 'Hadir') bg-emerald-100 text-emerald-700
                                        @elseif($attendance->status === 'Sakit') bg-amber-100 text-amber-700
                                        @elseif($attendance->status === 'Izin') bg-sky-100 text-sky-700
                                        @else bg-rose-100 text-rose-700 @endif">
                                        {{ $attendance->status }}
                                    </span>
                                </div>
                            @empty
                                <p class="text-sm text-slate-500">Belum ada data kehadiran.</p>
                            @endforelse
                        </div>
                    </section>
                </div>

                <div class="mt-8 grid gap-6 lg:grid-cols-3">
                    <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <h3 class="text-xl font-bold text-slate-900">Tagihan Terbaru</h3>
                        <div class="mt-5 space-y-3">
                            @forelse ($recentBills as $bill)
                                <div class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3">
                                    <p class="font-semibold text-slate-900">{{ $bill->student?->nama ?? 'Santri' }}</p>
                                    <p class="text-sm text-slate-500">{{ $bill->jenis }} • Rp {{ number_format($bill->nominal, 0, ',', '.') }}</p>
                                    <p class="mt-2 text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">{{ $bill->status }}</p>
                                </div>
                            @empty
                                <p class="text-sm text-slate-500">Belum ada tagihan.</p>
                            @endforelse
                        </div>
                    </section>

                    <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <h3 class="text-xl font-bold text-slate-900">Nilai Akademik</h3>
                        <div class="mt-5 space-y-3">
                            @forelse ($recentGrades as $grade)
                                <div class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3">
                                    <p class="font-semibold text-slate-900">{{ $grade->student?->nama ?? 'Santri' }}</p>
                                    <p class="text-sm text-slate-500">{{ $grade->mata_pelajaran }} • {{ $grade->nilai }}</p>
                                </div>
                            @empty
                                <p class="text-sm text-slate-500">Belum ada nilai.</p>
                            @endforelse
                        </div>
                    </section>

                    <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <h3 class="text-xl font-bold text-slate-900">Kesehatan Terbaru</h3>
                        <div class="mt-5 space-y-3">
                            @forelse ($recentHealth as $record)
                                <div class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3">
                                    <p class="font-semibold text-slate-900">{{ $record->student?->nama ?? 'Santri' }}</p>
                                    <p class="text-sm text-slate-500">{{ $record->jenis_pemeriksaan }} • {{ $record->status_kesehatan }}</p>
                                </div>
                            @empty
                                <p class="text-sm text-slate-500">Belum ada data kesehatan.</p>
                            @endforelse
                        </div>
                    </section>
                </div>
            </main>
        </div>
    </body>
</html>
