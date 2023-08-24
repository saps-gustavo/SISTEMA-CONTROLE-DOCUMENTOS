@if ($paginator->hasPages())
    <ul class="pagination center">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="disabled" style="color: #d1d1d1"><span><i class="material-icons">keyboard_arrow_left</i></span></li>
        @else
            <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev"><i class="material-icons">keyboard_arrow_left</i></a></li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="disabled" style="color: #d1d1d1"><span>{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="active" style="color: #fff; background-color: teal; padding: 5px;"><span>{{ $page }}</span></li>
                    @else
                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li><a href="{{ $paginator->nextPageUrl() }}" rel="next"><i class="material-icons">keyboard_arrow_right</i></a></li>
        @else
            <li class="disabled" style="color: #d1d1d1"><span><i class="material-icons">keyboard_arrow_right</i></span></li>
        @endif
    </ul>
@endif
