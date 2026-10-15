<article class="blog-card" data-anim="up">
<div class="blog-card__media">
<img src="{{ $post->imageUrl() }}" alt="{{ $post->featured_image_alt ?: $post->title }}" loading="lazy" width="1024" height="640"/>
@if ($post->category)<span class="blog-card__cat">{{ $post->category }}</span>@endif
</div>
<div class="blog-card__body">
<div class="blog-card__meta"><span>{{ optional($post->published_at)->format('M j, Y') }}</span><span>{{ $post->readingMinutes() }} min read</span></div>
<h3 class="blog-card__title"><a href="{{ $post->url() }}">{{ $post->title }}</a></h3>
<p class="blog-card__excerpt">{{ \Illuminate\Support\Str::limit($post->summary(), 150) }}</p>
<span class="blog-card__more">Read Article <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14m-7-7 7 7-7 7"/></svg></span>
</div>
</article>
