<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Manajemen Santri</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="module-shell">
        <div class="min-h-screen">
            <nav class="border-b border-slate-200 bg-white/80 shadow-sm backdrop-blur">
                <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-emerald-700">SIM</p>
                        <h1 class="text-xl font-bold text-slate-900">Manajemen Santri</h1>
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
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-emerald-100">Data santri</p>
                    <h2 class="mt-3 text-3xl font-black">Manajemen Santri</h2>
                </div>

                @if (session('success'))
                    <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 rounded-lg border border-rose-200 bg-rose-50 p-4 text-sm text-rose-800" role="alert">
                        <p class="font-semibold">Periksa kembali data santri:</p>
                        <ul class="mt-2 list-inside list-disc">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="grid gap-8 lg:grid-cols-[0.95fr_1.35fr]">
                    <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <h3 class="text-xl font-bold text-slate-900">Tambah Santri</h3>

                        <form action="{{ route('admin.santri.store') }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-4">
                            @csrf

                            <div>
                                <label class="mb-1 block text-sm font-medium text-slate-700">Nama lengkap</label>
                                <input type="text" name="nama" value="{{ old('nama') }}" required class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200" placeholder="Masukkan nama santri">
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-slate-700">NIS</label>
                                <input type="text" name="nis" value="{{ old('nis') }}" required class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200" placeholder="2026001">
                            </div>

                            <div class="grid gap-4 sm:grid-cols-2">
                                <div>
                                    <label class="mb-1 block text-sm font-medium text-slate-700">Jenis kelamin</label>
                                    <select name="jenis_kelamin" required class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                                        <option value="">Pilih</option>
                                        <option value="Laki-laki" @selected(old('jenis_kelamin') === 'Laki-laki')>Laki-laki</option>
                                        <option value="Perempuan" @selected(old('jenis_kelamin') === 'Perempuan')>Perempuan</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="mb-1 block text-sm font-medium text-slate-700">Tanggal lahir</label>
                                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                                </div>
                            </div>

                            <div class="grid gap-4 sm:grid-cols-2">
                                <div>
                                    <label class="mb-1 block text-sm font-medium text-slate-700">Kelas</label>
                                    <input type="text" name="kelas" value="{{ old('kelas') }}" required class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200" placeholder="VII-A">
                                </div>
                                <div>
                                    <label class="mb-1 block text-sm font-medium text-slate-700">Tahun masuk</label>
                                    <input type="number" name="tahun_masuk" value="{{ old('tahun_masuk') }}" required min="2000" max="2100" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200" placeholder="2026">
                                </div>
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-slate-700">Status</label>
                                <select name="status" required class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                                    <option value="">Pilih</option>
                                    <option value="Aktif" @selected(old('status') === 'Aktif')>Aktif</option>
                                    <option value="Cuti" @selected(old('status') === 'Cuti')>Cuti</option>
                                    <option value="Lulus" @selected(old('status') === 'Lulus')>Lulus</option>
                                    <option value="Pindah" @selected(old('status') === 'Pindah')>Pindah</option>
                                </select>
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-slate-700">Alamat</label>
                                <textarea name="alamat" rows="3" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200" placeholder="Jl. ...">{{ old('alamat') }}</textarea>
                            </div>

                            <div class="grid gap-4 sm:grid-cols-2">
                                <div>
                                    <label class="mb-1 block text-sm font-medium text-slate-700">Telepon orang tua</label>
                                    <input type="text" name="telepon" value="{{ old('telepon') }}" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200" placeholder="0812...">
                                </div>
                                <div>
                                    <label class="mb-1 block text-sm font-medium text-slate-700">Nama ayah</label>
                                    <input type="text" name="nama_ayah" value="{{ old('nama_ayah') }}" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200" placeholder="Nama ayah">
                                </div>
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-slate-700">Nama ibu</label>
                                <input type="text" name="nama_ibu" value="{{ old('nama_ibu') }}" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200" placeholder="Nama ibu">
                            </div>

                            <fieldset class="space-y-4 rounded-lg border border-slate-200 bg-slate-50 p-4">
                                <legend class="px-1 text-sm font-semibold text-slate-800">Akun orang tua / wali</legend>
                                <p class="text-xs leading-5 text-slate-600">Akun portal akan dibuat dan otomatis dihubungkan dengan santri ini. Gunakan email orang tua yang aktif.</p>
                                <div>
                                    <label for="email_orang_tua" class="mb-1 block text-sm font-medium text-slate-700">Email login orang tua</label>
                                    <input id="email_orang_tua" type="email" name="email_orang_tua" value="{{ old('email_orang_tua') }}" required autocomplete="email" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200" placeholder="wali@email.com">
                                </div>
                                <div class="grid gap-4 sm:grid-cols-2">
                                    <div>
                                        <label for="password_orang_tua" class="mb-1 block text-sm font-medium text-slate-700">Kata sandi awal</label>
                                        <input id="password_orang_tua" type="password" name="password_orang_tua" required minlength="8" autocomplete="new-password" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                                    </div>
                                    <div>
                                        <label for="password_orang_tua_confirmation" class="mb-1 block text-sm font-medium text-slate-700">Konfirmasi kata sandi</label>
                                        <input id="password_orang_tua_confirmation" type="password" name="password_orang_tua_confirmation" required minlength="8" autocomplete="new-password" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                                    </div>
                                </div>
                            </fieldset>

                            <x-image-upload-field label="Foto santri" />

                            <button type="submit" class="w-full rounded-xl bg-emerald-600 px-4 py-3 font-semibold text-white shadow-sm hover:bg-emerald-700">
                                Simpan Data Santri
                            </button>
                        </form>
                    </section>

                    <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="mb-4 flex items-center justify-between">
                            <h3 class="text-xl font-bold text-slate-900">Daftar Santri</h3>
                            <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.18em] text-emerald-700">
                                {{ $students->count() }} data
                            </span>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full text-left text-sm text-slate-700">
                                <thead class="bg-slate-50 text-xs uppercase tracking-[0.12em] text-slate-500">
                                    <tr>
                                        <th class="px-4 py-3">NIS</th>
                                        <th class="px-4 py-3">Nama</th>
                                        <th class="px-4 py-3">Kelas</th>
                                        <th class="px-4 py-3">Foto</th>
                                        <th class="px-4 py-3">Status</th>
                                        <th class="px-4 py-3">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($students as $student)
                                        <tr class="border-t border-slate-200">
                                            <td class="px-4 py-3 font-medium text-slate-900">{{ $student->nis }}</td>
                                            <td class="px-4 py-3">{{ $student->nama }}</td>
                                            <td class="px-4 py-3">{{ $student->kelas }}</td>
                                            <td class="px-4 py-3"><x-image-attachments :images="$student->imageAttachments" /></td>
                                            <td class="px-4 py-3">
                                                <span class="rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-700">
                                                    {{ $student->status }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="flex items-center gap-3">
                                                    <a href="{{ route('admin.santri.edit', $student) }}" class="font-semibold text-emerald-800 underline underline-offset-2 hover:text-emerald-950">Edit</a>
                                                    <form action="{{ route('admin.santri.destroy', $student) }}" method="POST" onsubmit="return confirm('Hapus data santri beserta seluruh data terkait?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="font-semibold text-rose-700 underline underline-offset-2 hover:text-rose-900">Hapus</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-4 py-10 text-center text-slate-500">Belum ada data santri.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </section>
                </div>
            </main>
        </div>
    </body>
</html>
