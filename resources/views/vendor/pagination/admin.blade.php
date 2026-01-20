@if ($paginator->hasPages())
    <nav class="admin-pagination precise-font" role="navigation" aria-label="Pagination Navigation">
        <div class="d-flex align-items-center gap-3 w-100">
            <div class="admin-pagination-side">
                @if ($paginator->onFirstPage())
                    <span class="admin-pagination-arrow is-disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">‹</span>
                @else
                    <a class="admin-pagination-arrow" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">‹</a>
                @endif
            </div>

            <div class="flex-grow-1">
                <ul class="pagination mb-0 justify-content-center flex-wrap gap-1">
                    @foreach ($elements as $element)
                        @if (is_string($element))
                            <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                        @endif

                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                                @else
                                    <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                </ul>
            </div>

            <div class="admin-pagination-side text-end">
                @if ($paginator->hasMorePages())
                    <a class="admin-pagination-arrow" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">›</a>
                @else
                    <span class="admin-pagination-arrow is-disabled" aria-disabled="true" aria-label="@lang('pagination.next')">›</span>
                @endif
            </div>
        </div>
    </nav>
@endif
