<div class="flex justify-center space-x-2 mt-4">
    @if($paginator->onFirstPage())
        <span class="px-3 py-1 bg-gray-700 rounded">Previous</span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-1 bg-gray-600 rounded">Previous</a>
    @endif

    @for($i = 1; $i <= $paginator->lastPage(); $i++)
        <a href="{{ $paginator->url($i) }}" class="px-3 py-1 {{ $paginator->currentPage() == $i ? 'bg-red-600' : 'bg-gray-600' }} rounded">{{ $i }}</a>
    @endfor

    @if($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-1 bg-gray-600 rounded">Next</a>
    @else
        <span class="px-3 py-1 bg-gray-700 rounded">Next</span>
    @endif
</div>
