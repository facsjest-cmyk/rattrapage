@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
        <div class="flex justify-between flex-1 sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-[#706f6c] bg-white border border-[#1b02a4]/20 cursor-default leading-5 rounded-xl">
                    {!! __('pagination.previous') !!}
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-[#1b02a4] border border-[#1b02a4]/20 leading-5 rounded-xl hover:bg-[#16028a] active:bg-[#120273] focus:outline-none focus:ring-2 focus:ring-[#1b02a4]/35 transition" aria-label="{!! __('pagination.previous') !!}">
                    {!! __('pagination.previous') !!}
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-white bg-[#1b02a4] border border-[#1b02a4]/20 leading-5 rounded-xl hover:bg-[#16028a] active:bg-[#120273] focus:outline-none focus:ring-2 focus:ring-[#1b02a4]/35 transition" aria-label="{!! __('pagination.next') !!}">
                    {!! __('pagination.next') !!}
                </a>
            @else
                <span class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-[#706f6c] bg-white border border-[#1b02a4]/20 cursor-default leading-5 rounded-xl">
                    {!! __('pagination.next') !!}
                </span>
            @endif
        </div>

        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-[#706f6c] leading-5">
                    {!! __('Showing') !!}
                    <span class="font-medium">{{ $paginator->firstItem() }}</span>
                    {!! __('to') !!}
                    <span class="font-medium">{{ $paginator->lastItem() }}</span>
                    {!! __('of') !!}
                    <span class="font-medium">{{ $paginator->total() }}</span>
                    {!! __('results') !!}
                </p>
            </div>

            <div>
                <span class="relative z-0 inline-flex rounded-md shadow-sm">
                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true" aria-label="{!! __('pagination.previous') !!}">
                            <span class="relative inline-flex items-center px-2 py-2 rounded-l-xl border border-[#1b02a4]/20 bg-white text-[#706f6c] cursor-default leading-5" aria-hidden="true">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center px-2 py-2 rounded-l-xl border border-[#1b02a4]/20 bg-[#1b02a4] text-white leading-5 hover:bg-[#16028a] active:bg-[#120273] focus:outline-none focus:ring-2 focus:ring-[#1b02a4]/35 transition" aria-label="{!! __('pagination.previous') !!}">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    @endif

                    @foreach ($elements as $element)
                        @if (is_string($element))
                            <span aria-disabled="true">
                                <span class="relative inline-flex items-center px-4 py-2 border border-[#1b02a4]/20 bg-white text-sm font-medium text-[#706f6c] cursor-default leading-5">{{ $element }}</span>
                            </span>
                        @endif

                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page">
                                        <span class="relative inline-flex items-center px-4 py-2 border border-[#1b02a4]/20 bg-[#1b02a4] text-sm font-medium text-white cursor-default leading-5">{{ $page }}</span>
                                    </span>
                                @else
                                    <a href="{{ $url }}" class="relative inline-flex items-center px-4 py-2 border border-[#1b02a4]/20 bg-white text-sm font-medium text-[#1b02a4] leading-5 hover:bg-[#1b02a4]/5 active:bg-[#1b02a4]/10 focus:outline-none focus:ring-2 focus:ring-[#1b02a4]/25 transition" aria-label="{!! __('Go to page :page', ['page' => $page]) !!}">{{ $page }}</a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="relative inline-flex items-center px-2 py-2 rounded-r-xl border border-[#1b02a4]/20 bg-[#1b02a4] text-white leading-5 hover:bg-[#16028a] active:bg-[#120273] focus:outline-none focus:ring-2 focus:ring-[#1b02a4]/35 transition" aria-label="{!! __('pagination.next') !!}">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    @else
                        <span aria-disabled="true" aria-label="{!! __('pagination.next') !!}">
                            <span class="relative inline-flex items-center px-2 py-2 rounded-r-xl border border-[#1b02a4]/20 bg-white text-[#706f6c] cursor-default leading-5" aria-hidden="true">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif
