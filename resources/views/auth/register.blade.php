<x-guest-layout>
    <div class="mb-4 text-center">
        <h2 class="h4 fw-bold text-dark mb-2">Create Account</h2>
        <p class="text-muted small">Join us and start your cinematic journey</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="mb-3 text-start">
            <label for="name" class="form-label fw-semibold text-secondary small">Full Name</label>
            <input id="name" class="form-control border-gray-300 shadow-sm focus:border-danger focus:ring-danger" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-1 small text-danger" />
        </div>

        <!-- Email Address -->
        <div class="mb-3 text-start">
            <label for="email" class="form-label fw-semibold text-secondary small">Email Address</label>
            <input id="email" class="form-control border-gray-300 shadow-sm focus:border-danger focus:ring-danger" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-1 small text-danger" />
        </div>

        <!-- Password -->
        <div class="mb-3 text-start">
            <label for="password" class="form-label fw-semibold text-secondary small">Password</label>
            <input id="password" class="form-control border-gray-300 shadow-sm focus:border-danger focus:ring-danger"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-1 small text-danger" />
        </div>

        <!-- Confirm Password -->
        <div class="mb-4 text-start">
            <label for="password_confirmation" class="form-label fw-semibold text-secondary small">Confirm Password</label>
            <input id="password_confirmation" class="form-control border-gray-300 shadow-sm focus:border-danger focus:ring-danger"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 small text-danger" />
        </div>

        <div class="mb-4">
            <button type="submit" class="btn btn-danger w-100 py-2 fw-bold rounded-pill shadow-sm">
                Register
            </button>
        </div>

        <div class="text-center">
            <p class="text-muted small mb-0">
                Already have an account? 
                <a href="{{ route('login') }}" class="text-danger fw-bold text-decoration-none">
                    Log in here
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
