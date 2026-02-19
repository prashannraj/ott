@props([
    'seasons' => [],
    'activeSeason' => null,
])

<div class="season-selector mb-4">
    <ul class="nav nav-pills nav-fill gap-2 flex-nowrap overflow-auto pb-2">
        @foreach($seasons as $season)
            <li class="nav-item">
                <a class="nav-link {{ ($activeSeason?->id ?? 0) === $season->id ? 'active bg-danger' : 'bg-dark' }}"
                   href="{{ route('shows.show', [$show->slug, 'season' => $season->number]) }}">
                    Season {{ $season->number }}
                </a>
            </li>
        @endforeach
    </ul>
</div>