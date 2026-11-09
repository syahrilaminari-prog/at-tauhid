<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-emerald-700">Pengaturan akun</p>
                <h1 class="mt-1 text-2xl font-black text-slate-900">Profil Saya</h1>
            </div>
            <a href="{{ $user->getDashboardRoute() }}" class="inline-flex items-center rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                Kembali ke dashboard
            </a>
        </div>
    </x-slot>

    <div class="min-h-[calc(100vh-9rem)] bg-slate-50 py-8">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            <section class="grid gap-5 lg:grid-cols-[minmax(0,1.3fr)_minmax(280px,0.7fr)]">
                <div class="flex items-center gap-5 rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-full bg-emerald-100 text-2xl font-black text-emerald-800" aria-hidden="true">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-slate-500">Akun aktif</p>
                        <h2 class="mt-1 truncate text-xl font-bold text-slate-900">{{ $user->name }}</h2>
                        <p class="mt-1 break-all text-sm text-slate-600">{{ $user->email }}</p>
                    </div>
                </div>

                <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="text-sm font-semibold uppercase tracking-[0.14em] text-slate-500">Informasi akun</h2>
                    <dl class="mt-4 space-y-4">
                        <div class="flex items-center justify-between gap-4">
                            <dt class="text-sm text-slate-600">Hak akses</dt>
                            <dd class="rounded-full bg-emerald-50 px-3 py-1 text-sm font-semibold text-emerald-800">{{ $user->role?->name ?? 'Pengguna' }}</dd>
                        </div>
                        <div class="flex items-center justify-between gap-4">
                            <dt class="text-sm text-slate-600">Email</dt>
                            <dd class="text-sm font-semibold {{ $user->hasVerifiedEmail() ? 'text-emerald-700' : 'text-amber-700' }}">
                                {{ $user->hasVerifiedEmail() ? 'Terverifikasi' : 'Belum diverifikasi' }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </section>

            <section class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm sm:p-7">
                @include('profile.partials.update-profile-information-form')
            </section>

            <section class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm sm:p-7">
                @include('profile.partials.update-password-form')
            </section>

            <section class="rounded-lg border border-rose-200 bg-white p-5 shadow-sm sm:p-7">
                    @include('profile.partials.delete-user-form')
            </section>
        </div>
    </div>
</x-app-layout>
