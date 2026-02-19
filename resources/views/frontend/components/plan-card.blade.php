@props([
    'plan',
    'isPopular' => false,
])

<div class="plan-card bg-gray-900 rounded-xl overflow-hidden shadow-xl border {{ $isPopular ? 'border-danger border-3' : 'border-gray-800' }} position-relative">
    @if($isPopular)
        <div class="position-absolute top-0 start-50 translate-middle-x badge bg-danger px-4 py-1 fs-6 fw-bold" style="transform: translateY(-50%);">
            MOST POPULAR
        </div>
    @endif

    <div class="p-4 p-md-5 text-center">
        <h3 class="fw-bold mb-1">{{ $plan->name }}</h3>
        <div class="display-5 fw-black text-danger my-3">
            {{ $plan->price > 0 ? number_format($plan->price) : 'Free' }}
            <small class="fs-6 fw-normal text-white-50">/ {{ $plan->period ?? 'month' }}</small>
        </div>

        <ul class="list-unstyled mb-4">
            @foreach($plan->features ?? ['HD Streaming', 'Watch on 2 devices', 'Cancel anytime'] as $feature)
                <li class="mb-2"><i class="fa fa-check text-success me-2"></i> {{ $feature }}</li>
            @endforeach
        </ul>

        <form action="{{ route('subscription.subscribe', $plan->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn {{ $isPopular ? 'btn-danger' : 'btn-outline-light' }} btn-lg w-100 rounded-pill fw-bold">
                {{ auth()->user()?->subscribed($plan->stripe_plan ?? $plan->id) ? 'Current Plan' : 'Choose Plan' }}
            </button>
        </form>
    </div>
</div>