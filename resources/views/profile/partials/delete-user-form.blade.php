<section class="space-y-6">
    <header>
        <h2 class="text-xl font-bold text-white">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 text-sm text-white-50">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. This action cannot be undone.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="bg-red-600 hover:bg-red-700 px-6 py-2 rounded-pill shadow-sm transition transform hover:scale-105"
    >{{ __('Delete Account') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 bg-dark text-white border-4 border-danger rounded-4">
            @csrf
            @method('delete')

            <h2 class="text-lg font-bold text-danger">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="mt-2 text-sm text-white-50">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-full bg-black border-secondary text-white focus:border-red-500 focus:ring-red-500 rounded-lg shadow-sm"
                    placeholder="{{ __('Enter your password to confirm') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')" class="rounded-pill px-4">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="bg-red-600 hover:bg-red-700 rounded-pill px-4">
                    {{ __('Delete Account') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>

