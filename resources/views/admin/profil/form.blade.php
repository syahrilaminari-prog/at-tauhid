<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $section->exists ? 'Edit' : 'Tambah' }} Profil Pesantren | At-Tauhid</title>
        <link rel="icon" type="image/png" href="{{ asset('images/LogoAttauhid.png') }}">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="module-shell">
        <div class="min-h-screen">
            <nav class="border-b border-slate-200 bg-white/90 shadow-sm backdrop-blur">
                <div class="mx-auto flex max-w-4xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-emerald-700">Profil Pesantren</p>
                        <h1 class="text-xl font-bold text-slate-900">{{ $section->exists ? 'Edit Bagian Profil' : 'Tambah Bagian Profil' }}</h1>
                    </div>
                    <a href="{{ route('admin.profil.index') }}" class="rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Kembali</a>
                </div>
            </nav>

            <main class="mx-auto max-w-4xl px-4 py-8 sm:px-6 lg:px-8">
                @if ($errors->any())
                    <div class="mb-6 rounded-md border border-rose-200 bg-rose-50 p-4 text-sm text-rose-800" role="alert">
                        <ul class="list-inside list-disc">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <section class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm sm:p-8">
                    <form action="{{ $section->exists ? route('admin.profil.update', $section) : route('admin.profil.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                        @csrf
                        @if ($section->exists)
                            @method('PATCH')
                        @endif

                        <div class="grid gap-5 md:grid-cols-2">
                            <div>
                                <label for="section_type" class="mb-1 block text-sm font-medium text-slate-700">Jenis bagian</label>
                                <select id="section_type" name="section_type" required class="w-full rounded-md border border-slate-300 bg-slate-50 px-3 py-2.5 focus:border-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                                    @foreach ($sectionTypes as $type => $label)
                                        <option value="{{ $type }}" @selected(old('section_type', $section->section_type) === $type)>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="sort_order" class="mb-1 block text-sm font-medium text-slate-700">Urutan tampil</label>
                                <input id="sort_order" name="sort_order" type="number" min="0" max="65535" required value="{{ old('sort_order', $section->sort_order ?? 0) }}" class="w-full rounded-md border border-slate-300 bg-slate-50 px-3 py-2.5 focus:border-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                            </div>
                        </div>

                        <div>
                            <label for="title" class="mb-1 block text-sm font-medium text-slate-700">Judul</label>
                            <input id="title" name="title" required maxlength="255" value="{{ old('title', $section->title) }}" class="w-full rounded-md border border-slate-300 bg-slate-50 px-3 py-2.5 focus:border-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                        </div>

                        <div>
                            <label for="slug" class="mb-1 block text-sm font-medium text-slate-700">Slug</label>
                            <input id="slug" name="slug" required maxlength="100" value="{{ old('slug', $section->slug) }}" placeholder="visi-pesantren" class="w-full rounded-md border border-slate-300 bg-slate-50 px-3 py-2.5 focus:border-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                        </div>

                        <div>
                            <label for="content" class="mb-1 block text-sm font-medium text-slate-700">Isi</label>
                            <textarea id="content" name="content" rows="8" required maxlength="20000" class="w-full rounded-md border border-slate-300 bg-slate-50 px-3 py-2.5 focus:border-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-200">{{ old('content', $section->content) }}</textarea>
                        </div>

                        @if ($section->exists && $section->imageAttachments->isNotEmpty())
                            <div>
                                <p class="mb-2 text-sm font-medium text-slate-700">Gambar tersimpan</p>
                                <x-image-attachments :images="$section->imageAttachments" />
                            </div>
                        @endif
                        <x-image-upload-field label="Gambar bagian profil (opsional)" />

                        <label class="flex items-center gap-3 text-sm font-medium text-slate-700">
                            <input type="hidden" name="is_published" value="0">
                            <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $section->exists ? $section->is_published : true)) class="rounded border-slate-300 text-emerald-700 focus:ring-emerald-600">
                            Terbitkan pada halaman publik
                        </label>

                        <div class="flex flex-wrap gap-3 border-t border-slate-200 pt-5">
                            <button type="submit" class="rounded-md bg-emerald-700 px-5 py-2.5 text-sm font-semibold text-white hover:bg-emerald-800 focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:ring-offset-2">Simpan</button>
                            <a href="{{ route('admin.profil.index') }}" class="rounded-md border border-slate-300 px-5 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">Batal</a>
                        </div>
                    </form>
                </section>
            </main>
        </div>
    </body>
</html>