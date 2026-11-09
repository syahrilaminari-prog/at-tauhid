<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Tagihan Santri</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="module-shell">
        <div class="min-h-screen">
            <nav class="border-b border-slate-200 bg-white/80 shadow-sm backdrop-blur">
                <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-violet-700">SIM</p>
                        <h1 class="text-xl font-bold text-slate-900">Tagihan Santri</h1>
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
                <div class="mb-8 rounded-3xl border border-violet-200 bg-gradient-to-r from-violet-600 to-indigo-600 p-8 text-white shadow-xl shadow-violet-100">
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-violet-100">Keuangan</p>
                    <h2 class="mt-3 text-3xl font-black">Tagihan Santri</h2>
                </div>

                @if (session('success'))
                    <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="grid gap-8 lg:grid-cols-[0.95fr_1.35fr]">
                    <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <h3 class="text-xl font-bold text-slate-900">Input Tagihan</h3>

                        <form action="{{ route('admin.tagihan.store') }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-4">
                            @csrf

                            <div>
                                <label class="mb-1 block text-sm font-medium text-slate-700">Santri</label>
                                <select name="student_id" required class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-violet-500 focus:outline-none focus:ring-2 focus:ring-violet-200">
                                    <option value="">Pilih santri</option>
                                    @foreach ($students as $student)
                                        <option value="{{ $student->id }}">{{ $student->nama }} ({{ $student->nis }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-slate-700">Jenis Tagihan</label>
                                <select name="jenis" required class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-violet-500 focus:outline-none focus:ring-2 focus:ring-violet-200">
                                    <option value="">Pilih</option>
                                    <option value="SPP">SPP</option>
                                    <option value="Uang Makan">Uang Makan</option>
                                    <option value="Seragam">Seragam</option>
                                    <option value="Kegiatan">Kegiatan</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-slate-700">Nominal</label>
                                <input type="number" name="nominal" min="0" step="1000" required class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-violet-500 focus:outline-none focus:ring-2 focus:ring-violet-200">
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-slate-700">Tanggal Jatuh Tempo</label>
                                <input type="date" name="tanggal_jatuh_tempo" required class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-violet-500 focus:outline-none focus:ring-2 focus:ring-violet-200">
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-slate-700">Status</label>
                                <select name="status" required class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-violet-500 focus:outline-none focus:ring-2 focus:ring-violet-200">
                                    <option value="">Pilih</option>
                                    <option value="Belum Bayar">Belum Bayar</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Sudah Bayar">Sudah Bayar</option>
                                </select>
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-slate-700">Keterangan</label>
                                <textarea name="keterangan" rows="3" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-violet-500 focus:outline-none focus:ring-2 focus:ring-violet-200" placeholder="Catatan pembayaran atau keterlambatan"></textarea>
                            </div>

                            <x-image-upload-field label="Bukti pembayaran atau tagihan" />

                            <button type="submit" class="w-full rounded-xl bg-violet-600 px-4 py-3 font-semibold text-white shadow-sm hover:bg-violet-700">
                                Simpan Tagihan
                            </button>
                        </form>
                    </section>

                    <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <h3 class="text-xl font-bold text-slate-900">Daftar Tagihan</h3>

                        <div class="mt-6 space-y-3">
                            @forelse ($bills as $bill)
                                <div class="flex items-center justify-between gap-4 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3">
                                    <div>
                                        <p class="font-semibold text-slate-900">{{ $bill->student?->nama ?? 'Santri' }}</p>
                                        <p class="text-sm text-slate-500">{{ $bill->jenis }} • Jatuh tempo {{ $bill->tanggal_jatuh_tempo }}</p>
                                        <p class="mt-1 text-sm font-medium text-slate-600">Rp {{ number_format($bill->nominal, 0, ',', '.') }}</p>
                                        <x-image-attachments :images="$bill->imageAttachments" />
                                    </div>
                                    <span class="rounded-full px-3 py-1 text-xs font-semibold
                                        @if($bill->status === 'Sudah Bayar') bg-emerald-100 text-emerald-700
                                        @elseif($bill->status === 'Pending') bg-amber-100 text-amber-700
                                        @else bg-rose-100 text-rose-700 @endif">
                                        {{ $bill->status }}
                                    </span>
                                </div>
                            @empty
                                <p class="text-sm text-slate-500">Belum ada data tagihan.</p>
                            @endforelse
                        </div>
                    </section>
                </div>
            </main>
        </div>
    </body>
</html>
