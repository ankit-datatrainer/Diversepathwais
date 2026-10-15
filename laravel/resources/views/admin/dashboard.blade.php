@extends('admin.layout')
@section('title', 'Dashboard')
@section('crumb', 'Welcome back, '.auth()->user()->name)
@section('actions')
<a class="btn btn--gold" href="{{ route('admin.posts.create') }}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg>New blog post</a>
@endsection

@section('content')
<div class="stats">
<div class="stat">
<span class="stat__icon stat__icon--green"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="m7 15 4-4 3 3 6-6"/></svg></span>
<div class="stat__label">Avg. SEO score</div>
<div class="stat__value">{{ $stats['seo_avg'] }}<small style="font-size:16px;color:var(--muted)">/100</small></div>
<div class="stat__meta"><a href="{{ route('admin.seo') }}">Open SEO dashboard →</a></div>
</div>
<div class="stat">
<span class="stat__icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/></svg></span>
<div class="stat__label">Website pages</div>
<div class="stat__value">{{ $stats['pages'] }}</div>
<div class="stat__meta"><a href="{{ route('admin.pages.index') }}">Manage page SEO →</a></div>
</div>
<div class="stat">
<span class="stat__icon stat__icon--gold"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 1 1 3 3L7 19l-4 1 1-4z"/></svg></span>
<div class="stat__label">Blog posts</div>
<div class="stat__value">{{ $stats['posts_published'] }}</div>
<div class="stat__meta">{{ $stats['posts_draft'] }} draft · {{ number_format($stats['blog_views']) }} total views</div>
</div>
<div class="stat">
<span class="stat__icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m2 7 10 6 10-6"/></svg></span>
<div class="stat__label">Enquiries</div>
<div class="stat__value">{{ $stats['enquiries'] }}</div>
<div class="stat__meta">{{ $stats['enquiries_unread'] }} unread · {{ $stats['enquiries_week'] }} this week</div>
</div>
</div>

<div class="grid grid--main">
<div class="card">
<div class="card__head"><div><h2>Latest enquiries</h2><p>Submitted from the website forms</p></div><div class="actions"><a class="btn btn--ghost btn--sm" href="{{ route('admin.enquiries.index') }}">View all</a></div></div>
<div class="card__body card__body--flush table-wrap">
@if ($recentEnquiries->isEmpty())
<div class="empty">No enquiries yet. They will appear here as soon as someone submits a form on the website.</div>
@else
<table class="table">
<thead><tr><th>Name</th><th class="hide-sm">Form</th><th class="hide-sm">Country</th><th>Received</th></tr></thead>
<tbody>
@foreach ($recentEnquiries as $e)
<tr class="{{ $e->is_read ? '' : 'is-unread' }}">
<td><a class="title" href="{{ route('admin.enquiries.show', $e) }}">{{ $e->name }}</a><div class="sub">{{ $e->email }} · {{ $e->phone }}</div></td>
<td class="hide-sm">{{ $e->formLabel() }}</td>
<td class="hide-sm">{{ $e->country }}</td>
<td>{{ $e->created_at->diffForHumans() }}</td>
</tr>
@endforeach
</tbody>
</table>
@endif
</div>
</div>

<div class="grid">
<div class="card">
<div class="card__head"><h2>SEO setup checklist</h2></div>
<div class="card__body" style="padding-top:6px;padding-bottom:6px">
<ul class="checks">
@foreach ($checklist as [$label, $done])
<li><span class="dot dot--{{ $done ? 'pass' : 'warn' }}">{{ $done ? '✓' : '!' }}</span><div><strong>{{ $label }}</strong>@unless ($done)<small><a href="{{ route('admin.settings.edit') }}">Set up in Global SEO Settings</a></small>@endunless</div></li>
@endforeach
</ul>
</div>
</div>
<div class="card">
<div class="card__head"><h2>Recently edited posts</h2></div>
<div class="card__body" style="padding-top:4px;padding-bottom:4px">
<ul class="list-plain">
@forelse ($recentPosts as $p)
<li><img class="thumb" src="{{ $p->imageUrl() }}" alt=""/><div style="min-width:0"><a class="title" href="{{ route('admin.posts.edit', $p) }}" style="font-weight:600;color:var(--ink)">{{ \Illuminate\Support\Str::limit($p->title, 52) }}</a><div class="muted" style="font-size:12px">{{ $p->updated_at->diffForHumans() }}</div></div></li>
@empty
<li class="muted">No posts yet.</li>
@endforelse
</ul>
</div>
</div>
<div class="card">
<div class="card__head"><h2>Quick links</h2></div>
<div class="card__body" style="display:flex;flex-wrap:wrap;gap:8px">
<a class="btn btn--ghost btn--sm" href="{{ route('sitemap') }}" target="_blank" rel="noopener">sitemap.xml</a>
<a class="btn btn--ghost btn--sm" href="{{ route('robots') }}" target="_blank" rel="noopener">robots.txt</a>
<a class="btn btn--ghost btn--sm" href="{{ route('blog.index') }}" target="_blank" rel="noopener">Blog page</a>
<a class="btn btn--ghost btn--sm" href="http://localhost/phpmyadmin/" target="_blank" rel="noopener">phpMyAdmin</a>
</div>
</div>
</div>
</div>
@endsection
