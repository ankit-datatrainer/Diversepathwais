{{-- Homepage "Group Media" cards: the latest published blog posts, same markup as the static site. --}}
<div class="media-track" data-media-track>@foreach ($latestPosts ?? [] as $post)<article class="media-card">
<img src="{{ $post->imageUrl() }}" alt="{{ $post->featured_image_alt ?: $post->title }}" loading="lazy" width="1024" height="576"/>
<div class="media-card__body"><h3>{{ $post->title }}</h3></div>
<a class="media-card__link" href="{{ $post->url() }}" aria-label="Read: {{ $post->title }}"></a>
</article>@endforeach</div>
@if (($latestPosts ?? collect())->isNotEmpty())
<div class="media-more" data-anim="up"><a class="btn btn--primary" href="{{ route('blog.index') }}">View All Articles <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14m-7-7 7 7-7 7"/></svg></a></div>
@endif
