<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Kelola Profil Pesantren | At-Tauhid</title>
        <link rel="icon" type="image/png" href="{{ asset('images/LogoAttauhid.png') }}">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="module-shell">
        <div class="min-h-screen">
            <nav class="border-b border-slate-200 bg-white/90 shadow-sm backdrop-blur">
                <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-emerald-700">Konten publik</p>
                        <h1 class="text-xl font-bold text-slate-900">Kelola Profil Pesantren</h1>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.dashboard') }}" class="rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Dashboard</a>
                        <a href="{{ route('profil') }}" class="rounded-md border border-emerald-200 px-4 py-2 text-sm font-semibold text-emerald-800 hover:bg-emerald-50">Lihat halaman publik</a>
                    </div>
                </div>
            </nav>

            <main class="mx-auto max-w-7xl space-y-6 px-4 py-8 sm:px-6 lg:px-8">
                @if (session('success'))
                    <div class="rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800" role="status">{{ session('success') }}</div>
                @endif
                @if ($errors->any())
                    <div class="rounded-md border border-rose-200 bg-rose-50 p-4 text-sm text-rose-800" role="alert">
                        <p class="font-semibold">Periksa kembali data:</p>
                        <ul class="mt-2 list-inside list-disc">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <section class="flex flex-wrap items-end justify-between gap-4 border-b border-slate-200 pb-5">
                    <div>
                        <h2 class="text-2xl font-black text-slate-900">Bagian profil</h2>
                        <p class="mt-1 text-sm text-slate-600">Atur urutan, isi, gambar, dan publikasi konten pesantren.</p>
                    </div>
                    <a href="{{ route('admin.profil.create') }}" class="inline-flex items-center rounded-md bg-emerald-700 px-4 py-2.5 text-sm font-semibold text-white hover:bg-emerald-800">Tambah bagian</a>
                </section>

                <div class="overflow-x-auto rounded-lg border border-slate-200 bg-white shadow-sm">
                    <table class="min-w-full text-left text-sm text-slate-700">
                        <thead class="bg-slate-50 text-xs uppercase tracking-[0.12em] text-slate-500">
                            <tr>
                                <th class="px-4 py-3">Urutan</th>
                                <th class="px-4 py-3">Jenis</th>
                                <th class="px-4 py-3">Judul</th>
                                <th class="px-4 py-3">Slug</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($sections as $section)
                                <tr class="border-t border-slate-200 align-top">
                                    <td class="px-4 py-3">{{ $section->sort_order }}</td>
                                    <td class="px-4 py-3">{{ $section->section_type_label }}</td>
                                    <td class="px-4 py-3 font-semibold text-slate-900">
                                        {{ $section->title }}
                                        <p class="mt-1 max-w-md truncate font-normal text-slate-500">{{ $section->content }}</p>
                                        <x-image-attachments :images="$section->imageAttachments" />
                                    </td>
                                    <td class="px-4 py-3 font-mono text-xs">{{ $section->slug }}</td>
                                    <td class="px-4 py-3">
                                        <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $section->is_published ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-700' }}">
                                            {{ $section->is_published ? 'Terbit' : 'Draft' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-3">
                                            <a href="{{ route('admin.profil.edit', $section) }}" class="font-semibold text-emerald-800 underline underline-offset-2">Edit</a>
                                            <form action="{{ route('admin.profil.destroy', $section) }}" method="POST" onsubmit="return confirm('Hapus bagian profil ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="font-semibold text-rose-700 underline underline-offset-2" type="submit">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="px-4 py-10 text-center text-slate-500">Belum ada bagian profil.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </body>
</html>