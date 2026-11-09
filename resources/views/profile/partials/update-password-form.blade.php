<section>
    <header>
        <h2 class="text-lg font-bold text-slate-900">
            Keamanan akun
        </h2>

        <p class="mt-1 text-sm text-slate-600">
            Ganti kata sandi secara berkala dan jangan gunakan kata sandi yang sama dengan akun lain.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" value="Kata sandi saat ini" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full rounded-md border-slate-300 bg-slate-50 text-slate-800 shadow-sm focus:border-emerald-600 focus:ring-emerald-600" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password" value="Kata sandi baru" />
            <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full rounded-md border-slate-300 bg-slate-50 text-slate-800 shadow-sm focus:border-emerald-600 focus:ring-emerald-600" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" value="Konfirmasi kata sandi baru" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full rounded-md border-slate-300 bg-slate-50 text-slate-800 shadow-sm focus:border-emerald-600 focus:ring-emerald-600" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="inline-flex items-center rounded-md bg-emerald-700 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-emerald-800 focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:ring-offset-2">
                Perbarui kata sandi
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm font-medium text-emerald-800"
                    role="status"
                >Kata sandi berhasil diperbarui.</p>
            @endif
        </div>
    </form>
</section>
