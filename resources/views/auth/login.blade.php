<x-guest-layout>
    <div class="mb-4 text-center">
        <h2 class="h4 fw-bold text-dark mb-2">Welcome Back</h2>
        <p class="text-muted small">Log in to your account to continue</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-3 text-start">
            <label for="email" class="form-label fw-semibold text-secondary small">Email Address</label>
            <input id="email" class="form-control border-gray-300 shadow-sm focus:border-danger focus:ring-danger" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-1 small text-danger" />
        </div>

        <!-- Password -->
        <div class="mb-3 text-start">
            <label for="password" class="form-label fw-semibold text-secondary small">Password</label>
            <input id="password" class="form-control border-gray-300 shadow-sm focus:border-danger focus:ring-danger"
                          type="password"
                          name="password"
                          required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-1 small text-danger" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="form-check">
                <input id="remember_me" type="checkbox" class="form-check-input rounded text-danger" name="remember">
                <label for="remember_me" class="form-check-label text-muted small">Remember me</label>
            </div>

            @if (Route::has('password.request'))
                <a class="text-danger text-decoration-none small fw-semibold" href="{{ route('password.request') }}">
                    Forgot password?
                </a>
            @endif
        </div>

        <div class="mb-4">
            <button type="submit" class="btn btn-danger w-100 py-2 fw-bold rounded-pill shadow-sm">
                Log in
            </button>
        </div>
    </form>

    <!-- Sign Up Link -->
    <div class="text-center mb-4">
        <p class="text-muted small">
            Don't have an account? 
            <a href="{{ route('register') }}" class="text-danger fw-bold text-decoration-none">
                Sign up for free
            </a>
        </p>
    </div>

    <!-- Social Login Buttons -->
    <div class="mt-4 pt-3 border-top border-light">
        <div class="text-center position-relative mb-4">
            <span class="bg-white px-3 text-muted small position-relative z-index-1">Or continue with</span>
            <div class="border-top w-100 position-absolute top-50 start-0 translate-middle-y"></div>
        </div>

        <div class="row g-3">
            <div class="col-6">
                <a href="{{ route('socialite.redirect', 'google') }}" class="btn btn-outline-secondary w-100 py-2 d-flex align-items-center justify-content-center gap-2 rounded-pill shadow-sm">
                    <i class="fab fa-google text-danger"></i>
                    <span class="small fw-semibold">Google</span>
                </a>
            </div>

            <div class="col-6">
                <a href="{{ route('socialite.redirect', 'facebook') }}" class="btn btn-outline-secondary w-100 py-2 d-flex align-items-center justify-content-center gap-2 rounded-pill shadow-sm">
                    <i class="fab fa-facebook text-primary"></i>
                    <span class="small fw-semibold">Facebook</span>
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>