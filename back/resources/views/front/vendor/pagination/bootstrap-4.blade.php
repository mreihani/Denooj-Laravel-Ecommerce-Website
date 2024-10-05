@if ($paginator->hasPages())
    <ul class="custom-pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="paginator-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                <span class="paginator-link" aria-hidden="true"><i class="icon-chevron-right"></i></span>
            </li>
        @else
            <li class="paginator-item">
                <a class="paginator-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')"><i class="icon-chevron-right"></i></a>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="paginator-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="paginator-item active" aria-current="page"><span class="paginator-link">{{ $page }}</span></li>
                    @else
                        <li class="paginator-item"><a class="paginator-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="paginator-item">
                <a class="paginator-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')"><i class="icon-chevron-left"></i></a>
            </li>
        @else
            <li class="paginator-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                <span class="paginator-link" aria-hidden="true"><i class="icon-chevron-left"></i></span>
            </li>
        @endif
    </ul>
@endif
