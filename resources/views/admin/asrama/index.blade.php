<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Asrama Santri</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="module-shell">
        <div class="min-h-screen">
            <nav class="border-b border-slate-200 bg-white/80 shadow-sm backdrop-blur">
                <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-cyan-700">SIM</p>
                        <h1 class="text-xl font-bold text-slate-900">Asrama Santri</h1>
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
                <div class="mb-8 rounded-3xl border border-cyan-200 bg-gradient-to-r from-cyan-600 to-sky-600 p-8 text-white shadow-xl shadow-cyan-100">
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-cyan-100">Asrama</p>
                    <h2 class="mt-3 text-3xl font-black">Asrama Santri</h2>
                </div>

                @if (session('success'))
                    <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="grid gap-8 lg:grid-cols-[0.95fr_1.35fr]">
                    <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <h3 class="text-xl font-bold text-slate-900">Assign Asrama</h3>

                        <form action="{{ route('admin.asrama.store') }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-4">
                            @csrf

                            <div>
                                <label class="mb-1 block text-sm font-medium text-slate-700">Santri</label>
                                <select name="student_id" required class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-200">
                                    <option value="">Pilih santri</option>
                                    @foreach ($students as $student)
                                        <option value="{{ $student->id }}">{{ $student->nama }} ({{ $student->nis }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-slate-700">Nama Kamar</label>
                                <input type="text" name="nama_kamar" required class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-200" placeholder="Putra 1 / Putri 2">
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-slate-700">Kapasitas</label>
                                <input type="number" name="kapasitas" min="1" max="200" required class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-200">
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-slate-700">Keterangan</label>
                                <textarea name="keterangan" rows="3" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-200" placeholder="Catatan kamar, lokasi, atau status"></textarea>
                            </div>

                            <x-image-upload-field label="Foto asrama atau kamar" />

                            <button type="submit" class="w-full rounded-xl bg-cyan-600 px-4 py-3 font-semibold text-white shadow-sm hover:bg-cyan-700">
                                Simpan Asrama
                            </button>
                        </form>
                    </section>

                    <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <h3 class="text-xl font-bold text-slate-900">Daftar Penempatan</h3>

                        <div class="mt-6 space-y-3">
                            @forelse ($dormitories as $dormitory)
                                <div class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3">
                                    <div class="flex items-center justify-between gap-3">
                                        <div>
                                            <p class="font-semibold text-slate-900">{{ $dormitory->student?->nama ?? 'Santri' }}</p>
                                            <p class="text-sm text-slate-500">{{ $dormitory->nama_kamar }}</p>
                                        </div>
                                        <span class="rounded-full bg-cyan-100 px-3 py-1 text-xs font-semibold text-cyan-700">{{ $dormitory->kapasitas }} orang</span>
                                    </div>
                                    <p class="mt-2 text-sm text-slate-600">{{ $dormitory->keterangan ?? 'Tidak ada keterangan' }}</p>
                                    <x-image-attachments :images="$dormitory->imageAttachments" />
                                </div>
                            @empty
                                <p class="text-sm text-slate-500">Belum ada penempatan asrama.</p>
                            @endforelse
                        </div>
                    </section>
                </div>
            </main>
        </div>
    </body>
</html>
