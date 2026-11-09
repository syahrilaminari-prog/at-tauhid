<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Kesehatan Santri</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="module-shell">
        <div class="min-h-screen">
            <nav class="border-b border-slate-200 bg-white/80 shadow-sm backdrop-blur">
                <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-rose-700">SIM</p>
                        <h1 class="text-xl font-bold text-slate-900">Kesehatan Santri</h1>
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
                <div class="mb-8 rounded-3xl border border-rose-200 bg-gradient-to-r from-rose-600 to-pink-600 p-8 text-white shadow-xl shadow-rose-100">
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-rose-100">Kesehatan</p>
                    <h2 class="mt-3 text-3xl font-black">Kesehatan Santri</h2>
                </div>

                @if (session('success'))
                    <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="grid gap-8 lg:grid-cols-[0.95fr_1.35fr]">
                    <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <h3 class="text-xl font-bold text-slate-900">Catat Kesehatan</h3>

                        <form action="{{ route('admin.kesehatan.store') }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-4">
                            @csrf

                            <div>
                                <label class="mb-1 block text-sm font-medium text-slate-700">Santri</label>
                                <select name="student_id" required class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-rose-500 focus:outline-none focus:ring-2 focus:ring-rose-200">
                                    <option value="">Pilih santri</option>
                                    @foreach ($students as $student)
                                        <option value="{{ $student->id }}">{{ $student->nama }} ({{ $student->nis }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-slate-700">Jenis Pemeriksaan</label>
                                <select name="jenis_pemeriksaan" required class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-rose-500 focus:outline-none focus:ring-2 focus:ring-rose-200">
                                    <option value="">Pilih</option>
                                    <option value="Pemeriksaan Fisik">Pemeriksaan Fisik</option>
                                    <option value="Pemeriksaan Gigi">Pemeriksaan Gigi</option>
                                    <option value="Pemeriksaan Mata">Pemeriksaan Mata</option>
                                    <option value="Vaksinasi">Vaksinasi</option>
                                    <option value="Pemeriksaan Rutin">Pemeriksaan Rutin</option>
                                </select>
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-slate-700">Tanggal Pemeriksaan</label>
                                <input type="date" name="tanggal_pemeriksaan" required class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-rose-500 focus:outline-none focus:ring-2 focus:ring-rose-200">
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-slate-700">Status Kesehatan</label>
                                <select name="status_kesehatan" required class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-rose-500 focus:outline-none focus:ring-2 focus:ring-rose-200">
                                    <option value="">Pilih</option>
                                    <option value="Sehat">Sehat</option>
                                    <option value="Sakit">Sakit</option>
                                    <option value="Rawat">Rawat</option>
                                    <option value="Catatan Khusus">Catatan Khusus</option>
                                </select>
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-slate-700">Catatan</label>
                                <textarea name="catatan" rows="3" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-rose-500 focus:outline-none focus:ring-2 focus:ring-rose-200" placeholder="Keluhan, hasil pemeriksaan, atau tindakan"></textarea>
                            </div>

                            <x-image-upload-field label="Foto pemeriksaan atau perawatan" />

                            <button type="submit" class="w-full rounded-xl bg-rose-600 px-4 py-3 font-semibold text-white shadow-sm hover:bg-rose-700">
                                Simpan Catatan Kesehatan
                            </button>
                        </form>
                    </section>

                    <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <h3 class="text-xl font-bold text-slate-900">Riwayat Kesehatan</h3>

                        <div class="mt-6 space-y-3">
                            @forelse ($healthRecords as $record)
                                <div class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3">
                                    <div class="flex items-center justify-between gap-3">
                                        <div>
                                            <p class="font-semibold text-slate-900">{{ $record->student?->nama ?? 'Santri' }}</p>
                                            <p class="text-sm text-slate-500">{{ $record->jenis_pemeriksaan }} • {{ $record->tanggal_pemeriksaan }}</p>
                                        </div>
                                        <span class="rounded-full px-3 py-1 text-xs font-semibold
                                            @if($record->status_kesehatan === 'Sehat') bg-emerald-100 text-emerald-700
                                            @elseif($record->status_kesehatan === 'Sakit') bg-amber-100 text-amber-700
                                            @elseif($record->status_kesehatan === 'Rawat') bg-rose-100 text-rose-700
                                            @else bg-sky-100 text-sky-700 @endif">
                                            {{ $record->status_kesehatan }}
                                        </span>
                                    </div>
                                    <p class="mt-2 text-sm text-slate-600">{{ $record->catatan ?? 'Tidak ada catatan tambahan.' }}</p>
                                    <x-image-attachments :images="$record->imageAttachments" />
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
