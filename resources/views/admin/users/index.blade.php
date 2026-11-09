<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Manajemen Pengguna</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="module-shell">
        <div class="min-h-screen">
            <nav class="border-b border-slate-200 bg-white/80 shadow-sm backdrop-blur">
                <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-sky-700">SIM</p>
                        <h1 class="text-xl font-bold text-slate-900">Manajemen Pengguna</h1>
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
                <div class="mb-8 rounded-3xl border border-sky-200 bg-gradient-to-r from-sky-600 to-cyan-600 p-8 text-white shadow-xl shadow-sky-100">
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-sky-100">Akses</p>
                    <h2 class="mt-3 text-3xl font-black">Manajemen Pengguna</h2>
                </div>

                @if (session('success'))
                    <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="grid gap-8 lg:grid-cols-[0.95fr_1.35fr]">
                    <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <h3 class="text-xl font-bold text-slate-900">Tambah Pengguna</h3>

                        <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-4">
                            @csrf

                            <div>
                                <label class="mb-1 block text-sm font-medium text-slate-700">Nama</label>
                                <input type="text" name="name" required class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" placeholder="Nama lengkap">
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-slate-700">Email</label>
                                <input type="email" name="email" required class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" placeholder="nama@email.com">
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-slate-700">Password</label>
                                <input type="password" name="password" required class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200">
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-slate-700">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" required class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200">
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-slate-700">Role</label>
                                <select name="role_id" required class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200">
                                    <option value="">Pilih role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <x-image-upload-field label="Foto pengguna" />

                            <button type="submit" class="w-full rounded-xl bg-sky-600 px-4 py-3 font-semibold text-white shadow-sm hover:bg-sky-700">
                                Simpan Pengguna
                            </button>
                        </form>
                    </section>

                    <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <h3 class="text-xl font-bold text-slate-900">Daftar Pengguna</h3>

                        <div class="mt-6 space-y-3">
                            @forelse ($users as $user)
                                <div class="flex items-center justify-between gap-4 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3">
                                    <div>
                                        <p class="font-semibold text-slate-900">{{ $user->name }}</p>
                                        <p class="text-sm text-slate-500">{{ $user->email }}</p>
                                        <x-image-attachments :images="$user->imageAttachments" />
                                    </div>
                                    <span class="rounded-full bg-sky-100 px-3 py-1 text-xs font-semibold text-sky-700">
                                        {{ $user->role?->name ?? 'Tanpa Role' }}
                                    </span>
                                </div>
                            @empty
                                <p class="text-sm text-slate-500">Belum ada pengguna.</p>
                            @endforelse
                        </div>
                    </section>
                </div>
            </main>
        </div>
    </body>
</html>
