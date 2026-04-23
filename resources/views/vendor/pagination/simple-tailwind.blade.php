<nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center gap-1">
    {{-- Previous Page Link --}}
    @if ($paginator->onFirstPage())
        <button disabled class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 text-gray-300 bg-white cursor-not-allowed opacity-40">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7"/></svg>
        </button>
    @else
        <button wire:click="previousPage" rel="prev" class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 text-gray-500 bg-white hover:bg-primary hover:text-white hover:border-primary transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7"/></svg>
        </button>
    @endif

    {{-- Page Numbers --}}
    @foreach ($elements as $element)
        @if (is_string($element))
            <button disabled class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 text-gray-400 bg-white text-sm font-semibold">{{ $element }}</button>
        @endif

        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <button wire:click="gotoPage({{ $page }})" class="w-8 h-8 flex items-center justify-center rounded-lg border bg-primary text-white border-primary text-sm font-semibold">{{ $page }}</button>
                @else
                    <button wire:click="gotoPage({{ $page }})" class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-600 hover:bg-primary hover:text-white hover:border-primary transition-all text-sm font-semibold">{{ $page }}</button>
                @endif
            @endforeach
        @endif
    @endforeach

    {{-- Next Page Link --}}
    @if ($paginator->hasMorePages())
        <button wire:click="nextPage" rel="next" class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 text-gray-500 bg-white hover:bg-primary hover:text-white hover:border-primary transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
        </button>
    @else
        <button disabled class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 text-gray-300 bg-white cursor-not-allowed opacity-40">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
        </button>
    @endif
</nav>
