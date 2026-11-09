<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Kehadiran Santri</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="module-shell">
        <div class="min-h-screen">
            <nav class="border-b border-slate-200 bg-white/80 shadow-sm backdrop-blur">
                <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-emerald-700">SIM</p>
                        <h1 class="text-xl font-bold text-slate-900">Kehadiran Santri</h1>
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
                <div class="mb-8 rounded-3xl border border-emerald-200 bg-gradient-to-r from-emerald-600 to-emerald-500 p-8 text-white shadow-xl shadow-emerald-100">
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-emerald-100">Absensi</p>
                    <h2 class="mt-3 text-3xl font-black">Kehadiran Santri</h2>
                </div>

                @if (session('success'))
                    <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="grid gap-8 lg:grid-cols-[0.95fr_1.35fr]">
                    <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <h3 class="text-xl font-bold text-slate-900">Input Kehadiran</h3>

                        <form action="{{ route('admin.kehadiran.store') }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-4">
                            @csrf

                            <div>
                                <label class="mb-1 block text-sm font-medium text-slate-700">Santri</label>
                                <select name="student_id" required class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                                    <option value="">Pilih santri</option>
                                    @foreach ($students as $student)
                                        <option value="{{ $student->id }}">{{ $student->nama }} ({{ $student->nis }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-slate-700">Tanggal</label>
                                <input type="date" name="tanggal" required class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-slate-700">Status</label>
                                <select name="status" required class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                                    <option value="">Pilih</option>
                                    <option value="Hadir">Hadir</option>
                                    <option value="Sakit">Sakit</option>
                                    <option value="Izin">Izin</option>
                                    <option value="Alpha">Alpha</option>
                                </select>
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-slate-700">Keterangan</label>
                                <textarea name="keterangan" rows="3" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200" placeholder="Tepat waktu / sakit / izin"></textarea>
                            </div>

                            <x-image-upload-field label="Lampiran kehadiran" />

                            <button type="submit" class="w-full rounded-xl bg-emerald-600 px-4 py-3 font-semibold text-white shadow-sm hover:bg-emerald-700">
                                Simpan Kehadiran
                            </button>
                        </form>
                    </section>

                    <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <h3 class="text-xl font-bold text-slate-900">Riwayat Kehadiran</h3>

                        <div class="mt-6 space-y-3">
                            @forelse ($attendances as $attendance)
                                <div class="flex items-center justify-between rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3">
                                    <div>
                                        <p class="font-semibold text-slate-900">{{ $attendance->student?->nama ?? 'Santri' }}</p>
                                        <p class="text-sm text-slate-500">{{ $attendance->tanggal }} • {{ $attendance->keterangan ?? 'Tidak ada keterangan' }}</p>
                                        <x-image-attachments :images="$attendance->imageAttachments" />
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
            </main>
        </div>
    </body>
</html>
