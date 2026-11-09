<section>
    <header>
        <h2 class="text-lg font-bold text-slate-900">
            Informasi profil
        </h2>

        <p class="mt-1 text-sm text-slate-600">
            Perbarui nama dan alamat email yang digunakan untuk masuk ke akun.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 grid gap-5 sm:grid-cols-2">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" value="Nama lengkap" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full rounded-md border-slate-300 bg-slate-50 text-slate-800 shadow-sm focus:border-emerald-600 focus:ring-emerald-600" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" value="Alamat email" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full rounded-md border-slate-300 bg-slate-50 text-slate-800 shadow-sm focus:border-emerald-600 focus:ring-emerald-600" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if (! $user->hasVerifiedEmail())
                <div class="mt-3 rounded-md border border-amber-200 bg-amber-50 p-3">
                    <p class="text-sm font-semibold text-amber-900">Email belum diverifikasi.</p>
                    <p class="mt-1 text-sm text-amber-800">Verifikasi email membantu menjaga keamanan akun Anda.</p>
                    <button form="send-verification" type="submit" class="mt-2 text-sm font-semibold text-emerald-800 underline underline-offset-2 hover:text-emerald-900 focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:ring-offset-2">
                            Kirim ulang email verifikasi
                        </button>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-sm font-medium text-emerald-800" role="status">Email verifikasi baru telah dikirim.</p>
                    @endif
                </div>
            @endif
        </div>

        <div class="sm:col-span-2">
            @if ($profileImage)
                <p class="mb-2 text-sm text-slate-600">Foto saat ini:</p>
                <x-image-attachments :images="collect([$profileImage])" />
            @endif
            <x-image-upload-field label="Foto profil" />
        </div>

        <div class="flex flex-wrap items-center gap-4 sm:col-span-2">
            <button type="submit" class="inline-flex items-center rounded-md bg-emerald-700 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-emerald-800 focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:ring-offset-2">
                Simpan perubahan
            </button>

            @if (session('status') === 'profile-updated')
                <p class="text-sm font-medium text-emerald-800" role="status">Perubahan profil tersimpan.</p>
            @endif
        </div>
    </form>
</section>
