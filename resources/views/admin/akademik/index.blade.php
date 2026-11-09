<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Nilai Akademik</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="module-shell">
        <div class="min-h-screen">
            <nav class="border-b border-slate-200 bg-white/80 shadow-sm backdrop-blur">
                <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-emerald-700">SIM</p>
                        <h1 class="text-xl font-bold text-slate-900">Nilai Akademik</h1>
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
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-emerald-100">Akademik</p>
                    <h2 class="mt-3 text-3xl font-black">Nilai Akademik</h2>
                </div>

                @if (session('success'))
                    <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="grid gap-8 lg:grid-cols-[0.95fr_1.35fr]">
                    <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <h3 class="text-xl font-bold text-slate-900">Input Nilai</h3>

                        <form action="{{ route('admin.akademik.store') }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-4">
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
                                <label class="mb-1 block text-sm font-medium text-slate-700">Mata pelajaran</label>
                                <input type="text" name="mata_pelajaran" required class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200" placeholder="Al-Qur'an">
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-slate-700">Semester</label>
                                <select name="semester" required class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                                    <option value="">Pilih</option>
                                    <option value="Ganjil">Ganjil</option>
                                    <option value="Genap">Genap</option>
                                </select>
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-slate-700">Nilai</label>
                                <input type="number" name="nilai" required min="0" max="100" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200" placeholder="92">
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-slate-700">Keterangan</label>
                                <textarea name="keterangan" rows="3" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200" placeholder="Sangat baik"></textarea>
                            </div>

                            <x-image-upload-field label="Lampiran nilai atau hafalan" />

                            <button type="submit" class="w-full rounded-xl bg-emerald-600 px-4 py-3 font-semibold text-white shadow-sm hover:bg-emerald-700">
                                Simpan Nilai
                            </button>
                        </form>
                    </section>

                    <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <h3 class="text-xl font-bold text-slate-900">Riwayat Nilai</h3>

                        <div class="mt-6 space-y-3">
                            @forelse ($grades as $grade)
                                <div class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3">
                                    <div class="flex items-center justify-between gap-4">
                                        <div>
                                            <p class="font-semibold text-slate-900">{{ $grade->student?->nama ?? 'Santri' }}</p>
                                            <p class="text-sm text-slate-500">{{ $grade->mata_pelajaran }} • {{ $grade->semester }}</p>
                                        </div>
                                        <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                                            {{ $grade->nilai }}
                                        </span>
                                    </div>
                                    <p class="mt-2 text-sm text-slate-600">{{ $grade->keterangan ?? 'Tidak ada keterangan' }}</p>
                                    <x-image-attachments :images="$grade->imageAttachments" />
                                </div>
                            @empty
                                <p class="text-sm text-slate-500">Belum ada data nilai.</p>
                            @endforelse
                        </div>
                    </section>
                </div>
            </main>
        </div>
    </body>
</html>
