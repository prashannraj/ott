@extends('frontend.layouts.app')

@section('title', 'Edit Profile - Madhesh Films')

@section('content')
    <div class="container py-5 mt-5">
        <div class="row g-4">
            <!-- Sidebar (Same as Dashboard) -->
            <div class="col-lg-3">
                <div class="card bg-dark text-white shadow-lg border-0 rounded-4 overflow-hidden sticky-top" style="top: 100px;">
                    <div class="card-body text-center p-4">
                        <div class="position-relative d-inline-block mb-3">
                            <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('icons/avatar.png') }}" 
                                 alt="{{ $user->name }}" 
                                 class="rounded-circle shadow-lg border-4 border-red-500" 
                                 width="120" height="120"
                                 style="object-fit: cover;">
                            @if($user->isPremium())
                                <span class="position-absolute bottom-0 end-0 bg-warning text-dark rounded-circle p-2 shadow-sm border border-white" title="Premium Member">
                                    <i class="fas fa-crown fa-xs"></i>
                                </span>
                            @endif
                        </div>
                        
                        <h4 class="fw-bold mb-1">{{ $user->name }}</h4>
                        <p class="text-muted small mb-3">{{ $user->email }}</p>

                        <div class="d-grid gap-2 mt-4">
                            <a href="{{ route('dashboard') }}" class="btn btn-outline-light btn-sm rounded-pill py-2 transition hover:bg-danger hover:border-danger">
                                <i class="fas fa-tachometer-alt me-2"></i> Back to Dashboard
                            </a>
                            <a href="{{ route('logout') }}" class="btn btn-outline-danger btn-sm rounded-pill py-2 transition hover:bg-danger hover:text-white"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </a>
                        </div>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>

            <!-- Main Content Area (Forms) -->
            <div class="col-lg-9">
                <div class="mb-4 text-center text-lg-start">
                    <h2 class="fw-bold text-white mb-1">Account Settings</h2>
                    <p class="text-white-50">Update your profile information and security settings.</p>
                </div>

                <div class="d-flex flex-column gap-4">
                    <!-- Profile Info Section -->
                    <div class="p-4 p-sm-5 bg-dark text-white shadow-lg rounded-4 border-0 border-start border-4 border-danger transition hover:shadow-xl duration-300">
                        <div class="w-100" style="max-width: 800px;">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>

                    <!-- Password Update Section -->
                    <div class="p-4 p-sm-5 bg-dark text-white shadow-lg rounded-4 border-0 border-start border-4 border-danger transition hover:shadow-xl duration-300">
                        <div class="w-100" style="max-width: 800px;">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>

                    <!-- Delete Account Section -->
                    <div class="p-4 p-sm-5 bg-dark text-white shadow-lg rounded-4 border-0 border-start border-4 border-danger transition hover:shadow-xl duration-300">
                        <div class="w-100" style="max-width: 800px;">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .transition {
        transition: all 0.3s ease;
    }
    .space-y-8 > :not([hidden]) ~ :not([hidden]) {
        margin-top: 2rem;
    }
</style>
@endpush

