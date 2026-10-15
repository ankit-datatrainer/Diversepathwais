@if ($paginator->hasPages())
<nav class="pager" aria-label="Pagination">
@if ($paginator->onFirstPage())<span class="is-disabled">&larr;</span>@else<a href="{{ $paginator->previousPageUrl() }}">&larr;</a>@endif
@foreach ($paginator->getUrlRange(max(1, $paginator->currentPage() - 3), min($paginator->lastPage(), $paginator->currentPage() + 3)) as $n => $url)
@if ($n === $paginator->currentPage())<span class="is-current">{{ $n }}</span>@else<a href="{{ $url }}">{{ $n }}</a>@endif
@endforeach
@if ($paginator->hasMorePages())<a href="{{ $paginator->nextPageUrl() }}">&rarr;</a>@else<span class="is-disabled">&rarr;</span>@endif
</nav>
@endif
