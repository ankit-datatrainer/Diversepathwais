@extends('layouts.site')

@section('content')
<section class="page-hero" style="background-image: url('{{ $post->imageUrl() }}');">
<div class="shell">
<nav class="breadcrumb" aria-label="Breadcrumb"><a href="{{ url('/') }}">Home</a><span>/</span><a href="{{ route('blog.index') }}">Blog</a><span>/</span>{{ \Illuminate\Support\Str::limit($post->title, 48) }}</nav>
<div class="page-hero__content">
<span class="page-hero__eyebrow" data-anim="up">{{ strtoupper($post->category ?: 'Insights') }}</span>
<h1 class="page-hero__title" data-anim="up">{{ $post->title }}</h1>
@if ($post->excerpt)
<p class="page-hero__lead" data-anim="up" style="--d:110ms">{{ $post->excerpt }}</p>
@endif
<div class="page-hero__meta" data-anim="up" style="--d:160ms">
<span><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg><time datetime="{{ optional($post->published_at)->toDateString() }}">{{ optional($post->published_at)->format('F j, Y') }}</time></span>
<span><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg>{{ $post->readingMinutes() }} min read</span>
@if ($post->author_name)
<span><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>{{ $post->author_name }}</span>
@endif
</div>
</div>
</div>
</section><section class="section">
<div class="shell">
<div class="layout">
<article data-anim="up">
@if ($post->featured_image)
<figure class="article-cover"><img src="{{ $post->imageUrl() }}" alt="{{ $post->featured_image_alt ?: $post->title }}" width="1024" height="576"/></figure>
@endif
<div class="prose">{!! $post->content !!}</div>
@if ($post->tagList())
<div class="article-tags">@foreach ($post->tagList() as $tag)<span>#{{ $tag }}</span>@endforeach</div>
@endif
<div class="article-share">Share:
<a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($shareUrl) }}" target="_blank" rel="noopener" aria-label="Share on Facebook"><svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M13.5 22v-8h2.7l.4-3.1h-3.1V8.9c0-.9.25-1.5 1.55-1.5H16.7V4.62A21 21 0 0 0 14.28 4.5c-2.4 0-4.05 1.47-4.05 4.16v2.24H7.5V14h2.73v8z"/></svg></a>
<a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode($shareUrl) }}" target="_blank" rel="noopener" aria-label="Share on LinkedIn"><svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg></a>
<a href="https://wa.me/?text={{ urlencode($post->title.' '.$shareUrl) }}" target="_blank" rel="noopener" aria-label="Share on WhatsApp"><svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.47 14.38c-.3-.15-1.75-.86-2.02-.96-.27-.1-.47-.15-.67.15s-.77.96-.94 1.16c-.17.2-.35.22-.65.07-.3-.15-1.25-.46-2.38-1.47-.88-.78-1.47-1.75-1.64-2.05-.17-.3-.02-.46.13-.61.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.08-.15-.67-1.6-.92-2.2-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.07-.79.37-.27.3-1.04 1.02-1.04 2.48s1.06 2.88 1.21 3.08c.15.2 2.1 3.2 5.08 4.49.71.3 1.26.49 1.69.63.71.22 1.36.19 1.87.12.57-.09 1.75-.72 2-1.41.25-.69.25-1.28.17-1.41-.07-.13-.27-.2-.57-.35zM12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2 22l5.25-1.38a9.9 9.9 0 0 0 4.79 1.22h.01c5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0 0 12.04 2zm0 18.15h-.01a8.2 8.2 0 0 1-4.19-1.15l-.3-.18-3.11.82.83-3.04-.2-.31a8.2 8.2 0 0 1-1.26-4.38c0-4.54 3.7-8.24 8.25-8.24a8.2 8.2 0 0 1 5.82 2.42 8.18 8.18 0 0 1 2.41 5.83c0 4.54-3.7 8.23-8.24 8.23z"/></svg></a>
</div>
</article>
<aside class="sidebar" data-anim-group="90">
@if ($recent->isNotEmpty())
<div class="side-card" data-anim="left"><h3>Recent Articles</h3>
<ul class="side-posts">@foreach ($recent as $r)<li><a href="{{ $r->url() }}"><img src="{{ $r->imageUrl() }}" alt="" loading="lazy" width="64" height="64"/><span><strong>{{ $r->title }}</strong><small>{{ optional($r->published_at)->format('M j, Y') }}</small></span></a></li>@endforeach</ul>
</div>
@endif
<div class="side-card" data-anim="left"><h3>Visa Categories</h3><ul><li><a href="{{ url('skilled-worker-visa') }}">Skilled Worker Visa</a></li><li><a href="{{ url('student-visa') }}">Student / Study Visa</a></li><li><a href="{{ url('family-visa') }}">Family Visa</a></li><li><a href="{{ url('visitor-visa') }}">Visitor Visa</a></li><li><a href="{{ url('work-permit') }}">Work Permit</a></li></ul></div>
<div class="side-card side-card--cta" data-anim="left">
<h3>Planning to Move Abroad?</h3>
<p>Talk to a licensed consultant and find out which pathway fits your profile.</p>
<a class="btn btn--gold btn--block" href="{{ url('contact-us') }}">Contact Us <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14m-7-7 7 7-7 7"/></svg></a>
</div>
</aside>
</div>
</div>
</section>
@if ($related->isNotEmpty())
<section class="section section--alt">
<div class="shell">
<div class="section-head related-head" data-anim="up"><span class="eyebrow">Keep Reading</span><h2>Related <span class="accent">Articles</span></h2></div>
<div class="blog-grid" data-anim-group="90">
@foreach ($related as $p)
@include('blog.card', ['post' => $p])
@endforeach
</div>
</div>
</section>
@endif
@endsection
