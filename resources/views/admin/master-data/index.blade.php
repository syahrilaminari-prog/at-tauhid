<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Master Data Kelas & Jurusan</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="module-shell">
        <div class="min-h-screen">
            <nav class="border-b border-slate-200 bg-white/80 shadow-sm backdrop-blur">
                <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-emerald-700">SIM</p>
                        <h1 class="text-xl font-bold text-slate-900">Master Data Kelas & Jurusan</h1>
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
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-emerald-100">Data umum</p>
                    <h2 class="mt-3 text-3xl font-black">Master Data Kelas & Jurusan</h2>
                </div>

                @if (session('success'))
                    <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="grid gap-8 lg:grid-cols-2">
                    <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <h3 class="text-xl font-bold text-slate-900">Tambah Jurusan</h3>

                        <form action="{{ route('admin.master-data.major.store') }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-4">
                            @csrf

                            <div>
                                <label class="mb-1 block text-sm font-medium text-slate-700">Nama jurusan</label>
                                <input type="text" name="nama" required class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200" placeholder="Tahfidz">
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-slate-700">Kode jurusan</label>
                                <input type="text" name="kode" required class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200" placeholder="THF">
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-slate-700">Deskripsi</label>
                                <textarea name="deskripsi" rows="3" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200" placeholder="Program tahfidz dan hafalan Qur'an"></textarea>
                            </div>

                            <x-image-upload-field field-id="major-image" label="Gambar jurusan" />

                            <button type="submit" class="w-full rounded-xl bg-emerald-600 px-4 py-3 font-semibold text-white shadow-sm hover:bg-emerald-700">
                                Simpan Jurusan
                            </button>
                        </form>
                    </section>

                    <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <h3 class="text-xl font-bold text-slate-900">Tambah Kelas</h3>

                        <form action="{{ route('admin.master-data.class.store') }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-4">
                            @csrf

                            <div>
                                <label class="mb-1 block text-sm font-medium text-slate-700">Nama kelas</label>
                                <input type="text" name="nama" required class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200" placeholder="VII-A">
                            </div>

                            <div class="grid gap-4 sm:grid-cols-2">
                                <div>
                                    <label class="mb-1 block text-sm font-medium text-slate-700">Tingkat</label>
                                    <input type="text" name="tingkat" required class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200" placeholder="VII">
                                </div>
                                <div>
                                    <label class="mb-1 block text-sm font-medium text-slate-700">Kapasitas</label>
                                    <input type="number" name="kapasitas" required min="1" max="500" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200" placeholder="35">
                                </div>
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-slate-700">Jurusan</label>
                                <select name="jurusan_id" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                                    <option value="">Tanpa jurusan</option>
                                    @foreach ($majors as $major)
                                        <option value="{{ $major->id }}">{{ $major->nama }} ({{ $major->kode }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <x-image-upload-field field-id="class-image" label="Gambar kelas" />

                            <button type="submit" class="w-full rounded-xl bg-slate-900 px-4 py-3 font-semibold text-white shadow-sm hover:bg-slate-700">
                                Simpan Kelas
                            </button>
                        </form>
                    </section>
                </div>

                <div class="mt-10 grid gap-8 lg:grid-cols-2">
                    <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <h3 class="text-xl font-bold text-slate-900">Daftar Jurusan</h3>
                        <div class="mt-4 space-y-3">
                            @forelse ($majors as $major)
                                <div class="flex items-center justify-between rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3">
                                    <div>
                                        <p class="font-semibold text-slate-900">{{ $major->nama }}</p>
                                        <p class="text-xs uppercase tracking-[0.2em] text-slate-500">{{ $major->kode }}</p>
                                        <x-image-attachments :images="$major->imageAttachments" />
                                    </div>
                                    <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                                        {{ $major->classes->count() }} kelas
                                    </span>
                                </div>
                            @empty
                                <p class="text-sm text-slate-500">Belum ada data jurusan.</p>
                            @endforelse
                        </div>
                    </section>

                    <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <h3 class="text-xl font-bold text-slate-900">Daftar Kelas</h3>
                        <div class="mt-4 space-y-3">
                            @forelse ($classes as $class)
                                <div class="flex items-center justify-between rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3">
                                    <div>
                                        <p class="font-semibold text-slate-900">{{ $class->nama }}</p>
                                        <p class="text-sm text-slate-500">{{ $class->tingkat }} • {{ $class->major?->nama ?? 'Umum' }}</p>
                                        <x-image-attachments :images="$class->imageAttachments" />
                                    </div>
                                    <span class="rounded-full bg-sky-100 px-3 py-1 text-xs font-semibold text-sky-700">
                                        {{ $class->kapasitas }} siswa
                                    </span>
                                </div>
                            @empty
                                <p class="text-sm text-slate-500">Belum ada data kelas.</p>
                            @endforelse
                        </div>
                    </section>
                </div>
            </main>
        </div>
    </body>
</html>
