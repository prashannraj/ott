@props([
    'paginator' => null,
    'onEachSide' => 2,  // how many pages to show on each side of current page
])

@if ($paginator->hasPages())
    <nav aria-label="Pagination" class="mt-8 flex justify-center items-center gap-2 flex-wrap">
        
        <!-- Previous -->
        <a 
            href="{{ $paginator->onFirstPage() ? '#' : $paginator->previousPageUrl() }}" 
            class="pagination-btn {{ $paginator->onFirstPage() ? 'opacity-50 cursor-not-allowed' : '' }}"
            aria-disabled="{{ $paginator->onFirstPage() ? 'true' : 'false' }}"
            aria-label="Previous page"
        >
            <i class="fas fa-chevron-left mr-1"></i> Prev
        </a>

        <!-- Page numbers with ellipsis logic -->
        @php
            $current = $paginator->currentPage();
            $last    = $paginator->lastPage();
            $start   = max(1, $current - $onEachSide);
            $end     = min($last, $current + $onEachSide);
            
            // Show first page + ellipsis if needed
            if ($start > 2) {
                echo '<a href="' . $paginator->url(1) . '" class="pagination-btn">1</a>';
                if ($start > 3) {
                    echo '<span class="pagination-ellipsis">...</span>';
                }
            }

            // Main range
            for ($page = $start; $page <= $end; $page++) {
                $active = $page === $current ? 'active' : '';
                echo '<a href="' . $paginator->url($page) . '" class="pagination-btn ' . $active . '">' . $page . '</a>';
            }

            // Show last page + ellipsis if needed
            if ($end < $last - 1) {
                if ($end < $last - 2) {
                    echo '<span class="pagination-ellipsis">...</span>';
                }
                echo '<a href="' . $paginator->url($last) . '" class="pagination-btn">' . $last . '</a>';
            }
        @endphp

        <!-- Next -->
        <a 
            href="{{ $paginator->hasMorePages() ? $paginator->nextPageUrl() : '#' }}" 
            class="pagination-btn {{ !$paginator->hasMorePages() ? 'opacity-50 cursor-not-allowed' : '' }}"
            aria-disabled="{{ !$paginator->hasMorePages() ? 'true' : 'false' }}"
            aria-label="Next page"
        >
            Next <i class="fas fa-chevron-right ml-1"></i>
        </a>
    </nav>
@endif