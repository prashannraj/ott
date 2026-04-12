<section>
    <header>
        <h2 class="text-xl font-bold text-white">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-white-50">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <!-- Avatar Update -->
        <div class="flex flex-column flex-sm-row align-items-center gap-4 p-4 bg-black rounded-3 border border-secondary">
            <div class="shrink-0">
                <img id='preview_img' class="rounded-circle shadow-md border-2 border-red-500" 
                    src="{{ $user->avatar ? Storage::disk('public')->url($user->avatar) : asset('icons/avatar.png') }}" 
                    alt="Current profile photo" 
                    style="width: 100px; height: 100px; object-fit: cover;" />
            </div>
            <div class="flex-grow text-center text-sm-start">
                <label class="block mb-2">
                    <span class="text-sm font-semibold text-white mb-2 block">Profile Picture</span>
                    <input type="file" name="avatar" onchange="loadFile(event)" class="block w-100 text-sm text-white-50
                      file:mr-4 file:py-2 file:px-4
                      file:rounded-pill file:border-0
                      file:text-sm file:font-semibold
                      file:bg-red-600 file:text-white
                      hover:file:bg-red-700
                      cursor-pointer
                    "/>
                </label>
                <p class="text-xs text-white-50 mt-2 mb-0">Recommended: Square image, max 2MB (JPG, PNG)</p>
            </div>
        </div>
        <script>
          var loadFile = function(event) {
            var output = document.getElementById('preview_img');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
              URL.revokeObjectURL(output.src) // free memory
            }
          };
        </script>
        <x-input-error class="mt-2" :messages="$errors->get('avatar')" />

        <div>
            <x-input-label for="name" :value="__('Full Name')" class="font-semibold text-white mb-2" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full bg-black border-secondary text-white focus:border-red-500 focus:ring-red-500 rounded-lg shadow-sm py-2 px-3" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email Address')" class="font-semibold text-white mb-2" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full bg-black border-secondary text-white focus:border-red-500 focus:ring-red-500 rounded-lg shadow-sm py-2 px-3" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-4 p-3 bg-warning text-dark rounded-lg">
                    <p class="text-sm mb-2">
                        {{ __('Your email address is unverified.') }}
                    </p>
                    <button form="send-verification" class="btn btn-dark btn-sm rounded-pill">
                        {{ __('Re-send Verification Email') }}
                    </button>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-xs">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button class="bg-red-600 hover:bg-red-700 px-6 py-2 rounded-pill shadow-sm transition transform hover:scale-105">
                {{ __('Update Profile') }}
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-success"
                ><i class="fas fa-check-circle me-1"></i> {{ __('Changes saved successfully.') }}</p>
            @endif
        </div>
    </form>
</section>

