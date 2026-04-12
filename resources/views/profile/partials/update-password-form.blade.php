<section>
    <header>
        <h2 class="text-xl font-bold text-white">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-white-50">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Current Password')" class="font-semibold text-white mb-2" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full bg-black border-secondary text-white focus:border-red-500 focus:ring-red-500 rounded-lg shadow-sm py-2 px-3" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('New Password')" class="font-semibold text-white mb-2" />
            <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full bg-black border-secondary text-white focus:border-red-500 focus:ring-red-500 rounded-lg shadow-sm py-2 px-3" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm New Password')" class="font-semibold text-white mb-2" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full bg-black border-secondary text-white focus:border-red-500 focus:ring-red-500 rounded-lg shadow-sm py-2 px-3" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button class="bg-red-600 hover:bg-red-700 px-6 py-2 rounded-pill shadow-sm transition transform hover:scale-105">
                {{ __('Update Password') }}
            </x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-success"
                ><i class="fas fa-check-circle me-1"></i> {{ __('Password updated successfully.') }}</p>
            @endif
        </div>
    </form>
</section>

