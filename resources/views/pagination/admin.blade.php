@php
    $end = $paginator->perPage() * ($paginator->currentPage() -1) + $paginator->count();
@endphp
<nav class="custom-pagination">
    <span class="total-item-pagination">{{ $paginator->firstItem() }} - {{ $end }} / {{ $paginator->total() }}</span>
    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if (!$paginator->onFirstPage())
            <li class="page-item">
                <a class="page-link btn btn-warning btn-radius-auto" href="{{ $paginator->url(1) }}" rel="prev" aria-label="@lang('pagination.previous')"><<</a>
            </li>
            <li class="page-item">
                <a class="page-link btn btn-warning btn-radius-auto" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')"><</a>
            </li>
        @endif
        {{-- Pagination Elements --}}
        @foreach(range(1, $paginator->lastPage()) as $i)
            @if ($paginator->currentPage() == 1)
                @if ( $i <= $paginator->currentPage() + 2)
                    @if ($i == $paginator->currentPage())
                        <li class="page-item active" aria-current="page"><span class="page-link btn btn-warning btn-radius-auto">{{ $i }}</span></li>
                    @else
                        <li class="page-item"><a class="page-link btn btn-warning btn-radius-auto" href="{{ $paginator->url($i) }}">{{ $i }}</a></li>
                    @endif
                @endif
            @elseif ($paginator->currentPage() == 2)
                @if ( $i <= $paginator->currentPage() + 1)
                    @if ($i == $paginator->currentPage())
                        <li class="page-item active" aria-current="page"><span class="page-link btn btn-warning btn-radius-auto">{{ $i }}</span></li>
                    @else
                        <li class="page-item"><a class="page-link btn btn-warning btn-radius-auto" href="{{ $paginator->url($i) }}">{{ $i }}</a></li>
                    @endif
                @endif
            @elseif ($paginator->currentPage() == $paginator->lastPage())
                @if ( $i >= $paginator->currentPage() - 1)
                    @if ($i == $paginator->currentPage())
                        <li class="page-item active" aria-current="page"><span class="page-link btn btn-warning btn-radius-auto">{{ $i }}</span></li>
                    @else
                        <li class="page-item active"><a class="page-link btn btn-warning btn-radius-auto" href="{{ $paginator->url($i-1) }}">{{ $i-1 }}</a></li>
                        <li class="page-item"><a class="page-link btn btn-warning btn-radius-auto" href="{{ $paginator->url($i) }}">{{ $i }}</a></li>
                    @endif
                @endif
            @elseif ($paginator->currentPage() == $paginator->lastPage()-1)
                @if ( $i >= $paginator->currentPage() - 1)
                    @if ($i == $paginator->currentPage())
                        <li class="page-item active" aria-current="page"><span class="page-link btn btn-warning btn-radius-auto">{{ $i }}</span></li>
                    @else
                        <li class="page-item"><a class="page-link btn btn-warning btn-radius-auto" href="{{ $paginator->url($i) }}">{{ $i }}</a></li>
                    @endif
                @endif
            @else
                @if ($i >= $paginator->currentPage() - 1 && $i <= $paginator->currentPage() + 1)
                    @if ($i == $paginator->currentPage())
                        <li class="page-item active" aria-current="page"><span class="page-link btn btn-warning btn-radius-auto">{{ $i }}</span></li>
                    @else
                        <li class="page-item"><a class="page-link btn btn-warning btn-radius-auto" href="{{ $paginator->url($i) }}">{{ $i }}</a></li>
                    @endif
                @endif
            @endif
        @endforeach
        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item">
                <a class="page-link btn btn-warning btn-radius-auto" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">></a>
            </li>
            <li class="page-item">
                <a class="page-link btn btn-warning btn-radius-auto" href="{{ $paginator->url($paginator->lastPage()) }}" rel="next" aria-label="@lang('pagination.next')">>></a>
            </li>
        @endif
    </ul>
</nav>
