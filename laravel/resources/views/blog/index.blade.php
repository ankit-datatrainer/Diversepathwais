@extends('layouts.site')

@section('content')
<section class="page-hero" style="background-image: url('{{ asset('assets/img/banners/banner-default.jpg') }}');">
<div class="shell">
<nav class="breadcrumb" aria-label="Breadcrumb"><a href="{{ url('/') }}">Home</a><span>/</span>@if ($category)<a href="{{ route('blog.index') }}">Blog</a><span>/</span>{{ $category }}@else Blog @endif</nav>
<div class="page-hero__content">
<span class="page-hero__eyebrow" data-anim="up">INSIGHTS &amp; NEWS</span>
<h1 class="page-hero__title" data-anim="up">{{ $category ? strtoupper($category) : 'OUR BLOG' }}</h1>
<p class="page-hero__lead" data-anim="up" style="--d:110ms">Expert guides, visa updates and real stories to help you study, work and settle abroad with confidence.</p>
</div>
</div>
</section><section class="section">
<div class="shell">
@if ($categories->isNotEmpty())
<nav class="blog-filters" aria-label="Blog categories" data-anim="up">
<a class="blog-chip{{ $category ? '' : ' is-active' }}" href="{{ route('blog.index') }}">All Articles</a>
@foreach ($categories as $cat => $count)
<a class="blog-chip{{ $category === $cat ? ' is-active' : '' }}" href="{{ route('blog.index', ['category' => $cat]) }}">{{ $cat }} <small>{{ $count }}</small></a>
@endforeach
</nav>
@endif

@if ($posts->isEmpty())
<div class="blog-empty" data-anim="up">
<h2>No articles yet</h2>
<p>New guides are on their way — check back soon.</p>
</div>
@else
<div class="blog-grid" data-anim-group="90">
@foreach ($posts as $post)
@include('blog.card', ['post' => $post])
@endforeach
</div>
@endif

@if ($posts->hasPages())
<nav class="blog-pager" aria-label="Blog pages">
@if ($posts->onFirstPage())<span class="is-disabled">&larr;</span>@else<a href="{{ $posts->previousPageUrl() }}" rel="prev" aria-label="Previous page">&larr;</a>@endif
@foreach ($posts->getUrlRange(1, $posts->lastPage()) as $n => $url)
@if ($n === $posts->currentPage())<span class="is-current" aria-current="page">{{ $n }}</span>@else<a href="{{ $url }}">{{ $n }}</a>@endif
@endforeach
@if ($posts->hasMorePages())<a href="{{ $posts->nextPageUrl() }}" rel="next" aria-label="Next page">&rarr;</a>@else<span class="is-disabled">&rarr;</span>@endif
</nav>
@endif
</div>
</section>
@endsection
