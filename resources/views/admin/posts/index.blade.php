@extends('admin.layout')
@section('title', 'Blogs')
@section('crumb', 'Super Admin / Blogs')
@section('actions')
<a class="btn btn--gold" href="{{ route('admin.posts.create') }}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg>New blog post</a>
@endsection

@section('content')
<div class="card">
<div class="card__head" style="flex-wrap:wrap">
<div class="filters">
@foreach (['' => 'All', 'published' => 'Published', 'scheduled' => 'Scheduled', 'draft' => 'Drafts'] as $key => $label)
<a class="pill {{ (string) $status === $key ? 'is-active' : '' }}" href="{{ route('admin.posts.index', array_filter(['status' => $key, 'q' => $search])) }}">{{ $label }}<small>{{ $counts[$key ?: 'all'] }}</small></a>
@endforeach
</div>
<form class="search" method="get" action="{{ route('admin.posts.index') }}">
@if ($status)<input type="hidden" name="status" value="{{ $status }}"/>@endif
<input class="input" type="search" name="q" value="{{ $search }}" placeholder="Search title or slug…"/>
<button class="btn btn--ghost" type="submit">Search</button>
</form>
</div>
<div class="card__body card__body--flush table-wrap">
@if ($posts->isEmpty())
<div class="empty">No blog posts found. <a href="{{ route('admin.posts.create') }}">Write the first one →</a></div>
@else
<table class="table">
<thead><tr><th></th><th>Title &amp; URL slug</th><th>Status</th><th class="hide-sm">Category</th><th class="hide-sm">SEO</th><th class="hide-sm num">Views</th><th></th></tr></thead>
<tbody>
@foreach ($posts as $post)
@php
    $state = $post->status === 'draft' ? 'draft' : ($post->isLive() ? 'published' : 'scheduled');
@endphp
<tr>
<td><img class="thumb" src="{{ $post->imageUrl() }}" alt=""/></td>
<td><a class="title" href="{{ route('admin.posts.edit', $post) }}">{{ $post->title }}</a><div class="sub">/blog/{{ $post->slug }}</div></td>
<td><span class="badge badge--{{ $state }}">{{ ucfirst($state) }}</span><div class="sub">{{ $post->published_at?->format('M j, Y') ?? '—' }}</div></td>
<td class="hide-sm">{{ $post->category ?: '—' }}</td>
<td class="hide-sm"><span class="score score--{{ $post->analysis['grade'] }}" style="--v:{{ $post->analysis['score'] }}"><span>{{ $post->analysis['score'] }}</span></span></td>
<td class="hide-sm num">{{ number_format($post->views) }}</td>
<td class="num">
<a class="btn btn--ghost btn--sm" href="{{ $post->url() }}" target="_blank" rel="noopener">{{ $state === 'published' ? 'View' : 'Preview' }}</a>
<a class="btn btn--primary btn--sm" href="{{ route('admin.posts.edit', $post) }}">Edit</a>
<form class="inline" method="post" action="{{ route('admin.posts.destroy', $post) }}" data-confirm="Delete “{{ $post->title }}”? This cannot be undone.">@csrf @method('DELETE')<button class="btn btn--danger btn--sm" type="submit">Delete</button></form>
</td>
</tr>
@endforeach
</tbody>
</table>
@endif
</div>
@include('admin.partials.pager', ['paginator' => $posts])
</div>
@endsection
