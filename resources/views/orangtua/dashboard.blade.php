<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Portal Orang Tua | Sekolah Islam Terpadu At-Tauhid</title>
        <link rel="icon" type="image/png" href="{{ asset('images/LogoAttauhid.png') }}">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-slate-100 text-slate-800 antialiased">
        <div class="min-h-screen">
            <nav class="border-b border-slate-200 bg-white/90 shadow-sm backdrop-blur">
                <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/LogoAttauhid.png') }}" alt="Logo Sekolah Islam Terpadu At-Tauhid" class="h-12 w-36 rounded-md border border-slate-200 bg-white object-cover shadow-sm" />
                        <div>
                            <p class="text-[10px] font-semibold uppercase tracking-[0.25em] text-emerald-700">Portal</p>
                            <h1 class="text-xl font-black text-slate-900">Orang Tua</h1>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">{{ $user->name }}</span>
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
                <section class="overflow-hidden rounded-[28px] bg-gradient-to-br from-emerald-600 via-teal-600 to-cyan-600 p-8 text-white shadow-xl shadow-emerald-200">
                    <p class="text-sm font-semibold uppercase tracking-[0.22em] text-emerald-100">Portal Orang Tua</p>
                    <h2 class="mt-3 text-3xl font-black">Monitoring perkembangan santri</h2>
                    <p class="mt-4 max-w-2xl text-sm text-emerald-50">
                        Pantau absensi, nilai, tagihan, dan kondisi kesehatan putra-putri Anda dalam satu dashboard yang aman dan ringkas.
                    </p>
                </section>

                @if($links->isEmpty())
                    <section class="mt-8 rounded-2xl border border-dashed border-slate-300 bg-white p-8 text-center">
                        <h3 class="text-xl font-bold text-slate-900">Belum ada data santri terhubung</h3>
                        <p class="mt-2 text-sm text-slate-600">Hubungi admin pesantren untuk menghubungkan akun Anda dengan data santri.</p>
                    </section>
                @else
                    <section class="mt-8 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-500">Santri terhubung</p>
                                <h3 class="mt-2 text-2xl font-black text-slate-900">{{ $selectedStudent?->nama ?? 'Pilih santri' }}</h3>
                            </div>
                            <div class="flex flex-wrap gap-2">
                                @foreach($links as $link)
                                    <a href="{{ route('orangtua.dashboard', ['student_id' => $link->student_id]) }}" class="rounded-full px-4 py-2 text-sm font-semibold {{ $selectedStudent && $selectedStudent->id === $link->student_id ? 'bg-emerald-600 text-white' : 'border border-slate-200 bg-white text-slate-700' }}">
                                        {{ $link->student->nama }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </section>

                    @if($selectedStudent)
                        <section class="mt-8 grid gap-5 md:grid-cols-2 xl:grid-cols-4">
                            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Kelas</p>
                                <p class="mt-4 text-3xl font-black text-slate-900">{{ $selectedStudent->kelas }}</p>
                                <p class="mt-2 text-sm text-slate-500">NIS: {{ $selectedStudent->nis }}</p>
                            </div>
                            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Kehadiran</p>
                                <p class="mt-4 text-3xl font-black text-slate-900">{{ $selectedStudent->attendances()->count() ? round(($attendanceSummary['hadir'] / $selectedStudent->attendances()->count()) * 100, 0) : 0 }}%</p>
                                <p class="mt-2 text-sm text-slate-500">Hadir dari total catatan</p>
                            </div>
                            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Tagihan</p>
                                <p class="mt-4 text-3xl font-black text-slate-900">Rp {{ number_format($unpaidBills, 0, ',', '.') }}</p>
                                <p class="mt-2 text-sm text-slate-500">Belum lunas</p>
                            </div>
                            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Kesehatan</p>
                                <p class="mt-4 text-3xl font-black text-slate-900">{{ $latestHealth?->status_kesehatan ?? 'Belum ada' }}</p>
                                <p class="mt-2 text-sm text-slate-500">{{ $latestHealth && $latestHealth->tanggal_pemeriksaan ? \Carbon\Carbon::parse($latestHealth->tanggal_pemeriksaan)->translatedFormat('d M Y') : 'Belum ada pemeriksaan' }}</p>
                            </div>
                        </section>

                        <section class="mt-8 grid gap-6 lg:grid-cols-2">
                            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                                <h4 class="text-xl font-black text-slate-900">Ringkasan kehadiran</h4>
                                <div class="mt-5 space-y-3">
                                    <div class="flex items-center justify-between rounded-xl bg-emerald-50 px-3 py-2 text-sm">
                                        <span class="font-medium text-emerald-700">Hadir</span>
                                        <span class="font-bold text-slate-900">{{ $attendanceSummary['hadir'] }}</span>
                                    </div>
                                    <div class="flex items-center justify-between rounded-xl bg-amber-50 px-3 py-2 text-sm">
                                        <span class="font-medium text-amber-700">Izin</span>
                                        <span class="font-bold text-slate-900">{{ $attendanceSummary['izin'] }}</span>
                                    </div>
                                    <div class="flex items-center justify-between rounded-xl bg-sky-50 px-3 py-2 text-sm">
                                        <span class="font-medium text-sky-700">Sakit</span>
                                        <span class="font-bold text-slate-900">{{ $attendanceSummary['sakit'] }}</span>
                                    </div>
                                    <div class="flex items-center justify-between rounded-xl bg-rose-50 px-3 py-2 text-sm">
                                        <span class="font-medium text-rose-700">Alpha</span>
                                        <span class="font-bold text-slate-900">{{ $attendanceSummary['alpha'] }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                                <h4 class="text-xl font-black text-slate-900">Nilai terbaru</h4>
                                <div class="mt-5 space-y-3">
                                    @forelse($latestGrades as $grade)
                                        <div class="flex items-center justify-between rounded-xl bg-slate-50 px-3 py-2">
                                            <div>
                                                <p class="font-semibold text-slate-900">{{ $grade->mata_pelajaran }}</p>
                                                <p class="text-xs text-slate-500">{{ $grade->semester }}</p>
                                            </div>
                                            <span class="rounded-full bg-emerald-100 px-2.5 py-1 text-sm font-bold text-emerald-700">{{ $grade->nilai }}</span>
                                        </div>
                                    @empty
                                        <p class="text-sm text-slate-500">Belum ada nilai yang tercatat.</p>
                                    @endforelse
                                </div>
                            </div>
                        </section>

                        <section class="mt-8 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm" aria-labelledby="health-history-heading">
                            <div class="flex flex-wrap items-end justify-between gap-3 border-b border-slate-200 pb-4">
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-rose-700">Kesehatan santri</p>
                                    <h4 id="health-history-heading" class="mt-1 text-xl font-black text-slate-900">Riwayat kesehatan dan perawatan</h4>
                                </div>
                                <span class="text-sm text-slate-500">{{ $healthHistory->count() }} catatan</span>
                            </div>

                            <div class="mt-4 divide-y divide-slate-200">
                                @forelse ($healthHistory as $record)
                                    <article class="py-4 first:pt-0 last:pb-0">
                                        <div class="flex flex-wrap items-start justify-between gap-3">
                                            <div>
                                                <p class="font-semibold text-slate-900">{{ $record->jenis_pemeriksaan }}</p>
                                                <time datetime="{{ $record->tanggal_pemeriksaan }}" class="mt-1 block text-sm text-slate-500">
                                                    {{ \Carbon\Carbon::parse($record->tanggal_pemeriksaan)->translatedFormat('d M Y') }}
                                                </time>
                                            </div>
                                            <span class="rounded-full px-3 py-1 text-xs font-semibold {{ match ($record->status_kesehatan) { 'Sehat' => 'bg-emerald-100 text-emerald-800', 'Sakit' => 'bg-amber-100 text-amber-800', 'Rawat' => 'bg-rose-100 text-rose-800', default => 'bg-sky-100 text-sky-800' } }}">
                                                {{ $record->status_kesehatan }}
                                            </span>
                                        </div>
                                        @if ($record->catatan)
                                            <p class="mt-3 whitespace-pre-line text-sm leading-6 text-slate-700">{{ $record->catatan }}</p>
                                        @endif
                                        <x-image-attachments :images="$record->imageAttachments" />
                                    </article>
                                @empty
                                    <p class="py-6 text-sm text-slate-500">Belum ada catatan kesehatan atau perawatan untuk santri ini.</p>
                                @endforelse
                            </div>
                        </section>

                        <section class="mt-8 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                            <h4 class="text-xl font-black text-slate-900">Data santri</h4>
                            <div class="mt-5 grid gap-4 md:grid-cols-2">
                                <div class="rounded-xl bg-slate-50 p-4">
                                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Nama</p>
                                    <p class="mt-2 text-lg font-bold text-slate-900">{{ $selectedStudent->nama }}</p>
                                </div>
                                <div class="rounded-xl bg-slate-50 p-4">
                                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Jenis kelamin</p>
                                    <p class="mt-2 text-lg font-bold text-slate-900">{{ $selectedStudent->jenis_kelamin }}</p>
                                </div>
                                <div class="rounded-xl bg-slate-50 p-4">
                                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Alamat</p>
                                    <p class="mt-2 text-lg font-bold text-slate-900">{{ $selectedStudent->alamat }}</p>
                                </div>
                                <div class="rounded-xl bg-slate-50 p-4">
                                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Telepon</p>
                                    <p class="mt-2 text-lg font-bold text-slate-900">{{ $selectedStudent->telepon }}</p>
                                </div>
                            </div>
                        </section>
                    @endif
                @endif
            </main>
        </div>
    </body>
</html>
