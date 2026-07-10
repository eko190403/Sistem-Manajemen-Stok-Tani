@if ($paginator->hasPages())
<nav>
    <ul class="pagination pagination-sm mb-0 justify-content-center">
        {{-- Previous --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled"><span class="page-link">Prev</span></li>
        @else
            <li class="page-item">
                <a class="page-link" href="javascript:void(0)" onclick="gotoPage({{ $paginator->currentPage() - 1 }})">Prev</a>
            </li>
        @endif

        {{-- Page Numbers --}}
        @foreach ($elements as $element)
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0)" onclick="gotoPage({{ $page }})">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="javascript:void(0)" onclick="gotoPage({{ $paginator->currentPage() + 1 }})">Next</a>
            </li>
        @else
            <li class="page-item disabled"><span class="page-link">Next</span></li>
        @endif
    </ul>
</nav>
@endif
