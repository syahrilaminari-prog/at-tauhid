<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Edit Santri | At-Tauhid</title>
        <link rel="icon" type="image/png" href="{{ asset('images/LogoAttauhid.png') }}">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="module-shell">
        <div class="min-h-screen">
            <nav class="border-b border-slate-200 bg-white/80 shadow-sm backdrop-blur">
                <div class="mx-auto flex max-w-5xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-emerald-700">Manajemen Santri</p>
                        <h1 class="text-xl font-bold text-slate-900">Edit Data Santri</h1>
                    </div>
                    <a href="{{ route('admin.santri.index') }}" class="rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Kembali</a>
                </div>
            </nav>

            <main class="mx-auto max-w-5xl px-4 py-8 sm:px-6 lg:px-8">
                @if ($errors->any())
                    <div class="mb-6 rounded-md border border-rose-200 bg-rose-50 p-4 text-sm text-rose-800" role="alert">
                        <p class="font-semibold">Periksa kembali data santri:</p>
                        <ul class="mt-2 list-inside list-disc">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="mb-6 rounded-md border border-emerald-200 bg-emerald-50 p-4 text-sm font-medium text-emerald-800" role="status">
                        {{ session('success') }}
                    </div>
                @endif

                <section class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm sm:p-8">
                    <p class="mb-6 text-sm text-slate-600">Perbarui data dasar, kontak keluarga, status, dan foto santri.</p>

                    <form action="{{ route('admin.santri.update', $student) }}" method="POST" enctype="multipart/form-data" class="grid gap-5 md:grid-cols-2">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label for="nama" class="mb-1 block text-sm font-medium text-slate-700">Nama lengkap</label>
                            <input id="nama" name="nama" value="{{ old('nama', $student->nama) }}" required maxlength="255" class="w-full rounded-md border border-slate-300 bg-slate-50 px-3 py-2.5 focus:border-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                        </div>
                        <div>
                            <label for="nis" class="mb-1 block text-sm font-medium text-slate-700">NIS</label>
                            <input id="nis" name="nis" value="{{ old('nis', $student->nis) }}" required maxlength="50" class="w-full rounded-md border border-slate-300 bg-slate-50 px-3 py-2.5 focus:border-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                        </div>
                        <div>
                            <label for="jenis_kelamin" class="mb-1 block text-sm font-medium text-slate-700">Jenis kelamin</label>
                            <select id="jenis_kelamin" name="jenis_kelamin" required class="w-full rounded-md border border-slate-300 bg-slate-50 px-3 py-2.5 focus:border-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                                <option value="Laki-laki" @selected(old('jenis_kelamin', $student->jenis_kelamin) === 'Laki-laki')>Laki-laki</option>
                                <option value="Perempuan" @selected(old('jenis_kelamin', $student->jenis_kelamin) === 'Perempuan')>Perempuan</option>
                            </select>
                        </div>
                        <div>
                            <label for="tanggal_lahir" class="mb-1 block text-sm font-medium text-slate-700">Tanggal lahir</label>
                            <input id="tanggal_lahir" name="tanggal_lahir" type="date" value="{{ old('tanggal_lahir', $student->tanggal_lahir) }}" required class="w-full rounded-md border border-slate-300 bg-slate-50 px-3 py-2.5 focus:border-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                        </div>
                        <div>
                            <label for="kelas" class="mb-1 block text-sm font-medium text-slate-700">Kelas</label>
                            <input id="kelas" name="kelas" value="{{ old('kelas', $student->kelas) }}" required maxlength="50" class="w-full rounded-md border border-slate-300 bg-slate-50 px-3 py-2.5 focus:border-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                        </div>
                        <div>
                            <label for="tahun_masuk" class="mb-1 block text-sm font-medium text-slate-700">Tahun masuk</label>
                            <input id="tahun_masuk" name="tahun_masuk" type="number" min="2000" max="2100" value="{{ old('tahun_masuk', $student->tahun_masuk) }}" required class="w-full rounded-md border border-slate-300 bg-slate-50 px-3 py-2.5 focus:border-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                        </div>
                        <div>
                            <label for="status" class="mb-1 block text-sm font-medium text-slate-700">Status</label>
                            <select id="status" name="status" required class="w-full rounded-md border border-slate-300 bg-slate-50 px-3 py-2.5 focus:border-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                                @foreach (['Aktif', 'Cuti', 'Lulus', 'Pindah'] as $status)
                                    <option value="{{ $status }}" @selected(old('status', $student->status) === $status)>{{ $status }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="telepon" class="mb-1 block text-sm font-medium text-slate-700">Telepon orang tua</label>
                            <input id="telepon" name="telepon" value="{{ old('telepon', $student->telepon) }}" maxlength="30" class="w-full rounded-md border border-slate-300 bg-slate-50 px-3 py-2.5 focus:border-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                        </div>
                        <div>
                            <label for="nama_ayah" class="mb-1 block text-sm font-medium text-slate-700">Nama ayah</label>
                            <input id="nama_ayah" name="nama_ayah" value="{{ old('nama_ayah', $student->nama_ayah) }}" maxlength="255" class="w-full rounded-md border border-slate-300 bg-slate-50 px-3 py-2.5 focus:border-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                        </div>
                        <div>
                            <label for="nama_ibu" class="mb-1 block text-sm font-medium text-slate-700">Nama ibu</label>
                            <input id="nama_ibu" name="nama_ibu" value="{{ old('nama_ibu', $student->nama_ibu) }}" maxlength="255" class="w-full rounded-md border border-slate-300 bg-slate-50 px-3 py-2.5 focus:border-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                        </div>
                        <div class="md:col-span-2">
                            <label for="alamat" class="mb-1 block text-sm font-medium text-slate-700">Alamat</label>
                            <textarea id="alamat" name="alamat" rows="3" maxlength="500" class="w-full rounded-md border border-slate-300 bg-slate-50 px-3 py-2.5 focus:border-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-200">{{ old('alamat', $student->alamat) }}</textarea>
                        </div>
                        <div class="md:col-span-2">
                            @if ($student->imageAttachments->isNotEmpty())
                                <p class="mb-2 text-sm font-medium text-slate-700">Foto tersimpan</p>
                                <x-image-attachments :images="$student->imageAttachments" />
                                <p class="mt-2 text-xs text-slate-500">Pilih foto baru jika ingin mengganti foto saat ini.</p>
                            @endif
                            <x-image-upload-field label="Foto santri" />
                        </div>
                        <div class="flex flex-wrap gap-3 border-t border-slate-200 pt-5 md:col-span-2">
                            <button type="submit" class="rounded-md bg-emerald-700 px-5 py-2.5 text-sm font-semibold text-white hover:bg-emerald-800 focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:ring-offset-2">Simpan perubahan</button>
                            <a href="{{ route('admin.santri.index') }}" class="rounded-md border border-slate-300 px-5 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">Batal</a>
                        </div>
                    </form>
                </section>

                <section class="mt-6 rounded-lg border border-slate-200 bg-white p-5 shadow-sm sm:p-8">
                    <div class="max-w-3xl">
                        <h2 class="text-lg font-bold text-slate-900">Akun orang tua terhubung</h2>
                        <p class="mt-1 text-sm text-slate-600">Hubungkan akun dengan role Orang Tua agar wali dapat memantau santri ini di portal mereka.</p>
                    </div>

                    @if ($student->parents->isNotEmpty())
                        <ul class="mt-4 space-y-2">
                            @foreach ($student->parents as $parent)
                                <li class="flex flex-wrap items-center justify-between gap-2 rounded-md border border-slate-200 bg-slate-50 px-4 py-3 text-sm">
                                    <span class="font-semibold text-slate-900">{{ $parent->name }} <span class="font-normal text-slate-500">({{ $parent->email }})</span></span>
                                    <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-800">{{ $parent->pivot->hubungan }} · {{ $parent->pivot->status }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="mt-4 rounded-md border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-900">Belum ada akun orang tua yang terhubung.</p>
                    @endif

                    @if ($parents->isNotEmpty())
                        <form action="{{ route('admin.santri.parent.store', $student) }}" method="POST" class="mt-5 grid gap-4 sm:grid-cols-[minmax(0,1fr)_180px_auto] sm:items-end">
                            @csrf
                            <div>
                                <label for="parent-user-id" class="mb-1 block text-sm font-medium text-slate-700">Pilih akun orang tua</label>
                                <select id="parent-user-id" name="user_id" required class="w-full rounded-md border border-slate-300 bg-slate-50 px-3 py-2.5 focus:border-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                                    <option value="">Pilih akun</option>
                                    @foreach ($parents as $parent)
                                        <option value="{{ $parent->id }}" @selected((string) old('user_id') === (string) $parent->id)>{{ $parent->name }} · {{ $parent->email }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="parent-relationship" class="mb-1 block text-sm font-medium text-slate-700">Hubungan</label>
                                <select id="parent-relationship" name="hubungan" required class="w-full rounded-md border border-slate-300 bg-slate-50 px-3 py-2.5 focus:border-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                                    @foreach (['Ayah', 'Ibu', 'Wali'] as $relationship)
                                        <option value="{{ $relationship }}" @selected(old('hubungan', 'Wali') === $relationship)>{{ $relationship }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="rounded-md bg-emerald-700 px-5 py-2.5 text-sm font-semibold text-white hover:bg-emerald-800 focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:ring-offset-2">Hubungkan</button>
                        </form>
                    @else
                        <p class="mt-4 text-sm text-slate-600">Belum ada akun Orang Tua. Buat akun terlebih dahulu melalui <a href="{{ route('admin.users.index') }}" class="font-semibold text-emerald-800 underline underline-offset-2">Manajemen Pengguna</a>.</p>
                    @endif
                </section>
            </main>
        </div>
    </body>
</html>