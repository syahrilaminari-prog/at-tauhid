<section class="space-y-6">
    <header>
        <h2 class="text-lg font-bold text-rose-900">
            Hapus akun
        </h2>

        <p class="mt-1 max-w-3xl text-sm leading-6 text-slate-600">
            Tindakan ini permanen dan Anda akan keluar dari sistem. Pastikan data yang masih diperlukan sudah dicatat sebelum melanjutkan.
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >Hapus akun</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-bold text-slate-900">
                Hapus akun secara permanen?
            </h2>

            <p class="mt-1 text-sm leading-6 text-slate-600">
                Masukkan kata sandi untuk mengonfirmasi penghapusan akun. Tindakan ini tidak dapat dibatalkan.
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="Kata sandi" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="Kata sandi saat ini"
                    autocomplete="current-password"
                    required
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close-modal', 'confirm-user-deletion')">
                    Batal
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    Hapus akun permanen
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
