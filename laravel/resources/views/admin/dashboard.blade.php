@extends('admin.layout')
@section('title', 'Dashboard')
@section('crumb', now()->format('l, j F Y'))
@section('actions')
<a class="btn btn--gold" href="{{ route('admin.posts.create') }}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg><span>New post</span></a>
@endsection

@section('content')
@php
    $hour = (int) now()->format('G');
    $greeting = $hour < 12 ? 'Good morning' : ($hour < 17 ? 'Good afternoon' : 'Good evening');
    $avgGrade = $stats['seo_avg'] >= 80 ? 'good' : ($stats['seo_avg'] >= 50 ? 'ok' : 'poor');

    // 14-day bar chart geometry
    $W = 700; $H = 210; $padL = 30; $padB = 26; $padT = 12;
    $max = max(1, $days->max('count'));
    $step = $max <= 4 ? 1 : (int) ceil($max / 4);
    $top = $step * (int) ceil($max / $step);
    $slot = ($W - $padL) / $days->count();
    $bw = min(26, $slot * .56);
    $plotH = $H - $padB - $padT;
    $totalDays = $days->sum('count');
    $trend = $stats['enquiries_week'] - $stats['enquiries_prev_week'];
@endphp

<section class="hero">
<svg class="hero__routes" viewBox="0 0 500 220" preserveAspectRatio="xMaxYMid slice" aria-hidden="true">
<path class="route" d="M190 120 C 260 30, 380 20, 470 80"/>
<path class="route" d="M230 210 C 300 150, 400 150, 490 190"/>
<path class="route--gold route" d="M190 120 C 260 30, 380 20, 470 80"/>
<circle class="pin" cx="190" cy="120" r="4"/><circle class="pin-ring" cx="190" cy="120" r="5" stroke-width="1.5"/>
<circle class="pin" cx="470" cy="80" r="4"/>
<g fill="#fff"><path d="M0-7 1.4-2.2 7 1v1.6L1.4.6V4.2l1.9 1.4V7L0 6 -3.3 7V5.6l1.9-1.4V.6L-7 2.6V1L-1.4-2.2Z" transform="rotate(90) scale(1.3)"/><animateMotion dur="6s" repeatCount="indefinite" rotate="auto" path="M190 120 C 260 30, 380 20, 470 80"/></g>
</svg>
<span class="hero__eyebrow"><i></i>Control centre · live</span>
<h2>{{ $greeting }}, <em>{{ auth()->user()->name }}</em>.</h2>
<p>
@if ($stats['enquiries_unread'])
You have <strong style="color:#fff">{{ $stats['enquiries_unread'] }} unread {{ \Illuminate\Support\Str::plural('enquiry', $stats['enquiries_unread']) }}</strong> waiting, and the site-wide SEO score is <strong style="color:#fff">{{ $stats['seo_avg'] }}/100</strong>.
@else
Inbox zero. The site-wide SEO score is <strong style="color:#fff">{{ $stats['seo_avg'] }}/100</strong> across {{ $grades['total'] }} URLs.
@endif
</p>
<div class="hero__actions">
<a class="btn btn--gold" href="{{ route('admin.enquiries.index', ['unread' => 1]) }}">Review enquiries <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M5 12h14m-6-6 6 6-6 6"/></svg></a>
<a class="btn btn--glass" href="{{ route('admin.seo') }}">Open SEO dashboard</a>
<button class="btn btn--glass" type="button" data-cmdk-open>Quick search <kbd style="background:rgba(255,255,255,.1);border-color:rgba(255,255,255,.2);color:#cbd5e1">Ctrl K</kbd></button>
</div>
</section>

<div class="kpis">
<div class="stat">
<span class="stat__icon stat__icon--green"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="m7 15 4-4 3 3 6-6"/></svg></span>
<div class="stat__label">Avg. SEO score</div>
<div class="stat__value"><span data-count-to="{{ $stats['seo_avg'] }}">{{ $stats['seo_avg'] }}</span><small>/100</small></div>
<div class="progress" style="margin-top:14px"><i style="--w:{{ $stats['seo_avg'] }}"></i></div>
<div class="stat__meta"><a href="{{ route('admin.seo') }}">{{ $grades['good'] }} of {{ $grades['total'] }} URLs rated good →</a></div>
</div>
<div class="stat">
<span class="stat__icon stat__icon--gold"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m2 7 10 6 10-6"/></svg></span>
<div class="stat__label">Enquiries · 7 days</div>
<div class="stat__value"><span data-count-to="{{ $stats['enquiries_week'] }}">{{ $stats['enquiries_week'] }}</span></div>
<div class="stat__meta" style="margin-top:14px">
@if ($trend > 0)<span class="trend">▲ {{ $trend }} vs last week</span>@elseif ($trend < 0)<span class="trend trend--flat">▼ {{ abs($trend) }} vs last week</span>@else<span class="trend trend--flat">Same as last week</span>@endif
</div>
<div class="stat__meta">{{ $stats['enquiries'] }} all-time · {{ $stats['enquiries_unread'] }} unread</div>
</div>
<div class="stat">
<span class="stat__icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 1 1 3 3L7 19l-4 1 1-4z"/></svg></span>
<div class="stat__label">Published articles</div>
<div class="stat__value"><span data-count-to="{{ $stats['posts_published'] }}">{{ $stats['posts_published'] }}</span></div>
<div class="stat__meta" style="margin-top:14px"><span class="badge badge--draft">{{ $stats['posts_draft'] }} draft</span> <span class="badge">{{ number_format($stats['blog_views']) }} reads</span></div>
<div class="stat__meta"><a href="{{ route('admin.posts.index') }}">Manage blog →</a></div>
</div>
<div class="stat">
<span class="stat__icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/></svg></span>
<div class="stat__label">Website pages</div>
<div class="stat__value"><span data-count-to="{{ $stats['pages'] }}">{{ $stats['pages'] }}</span></div>
<div class="stat__meta" style="margin-top:14px">Every page has editable meta, social &amp; schema</div>
<div class="stat__meta"><a href="{{ route('admin.pages.index') }}">Edit page SEO →</a></div>
</div>
</div>

<div class="grid grid--wide">
<div class="card">
<div class="card__head">
<div><h2>Enquiries, last 14 days</h2><p>Every form submission on the website · today in gold</p></div>
<div class="actions chart-sum"><b>{{ $totalDays }}</b><span>total</span></div>
</div>
<div class="card__body">
<div class="chart" data-chart>
<svg viewBox="0 0 {{ $W }} {{ $H }}" role="img" aria-label="Bar chart of enquiries per day for the last 14 days, {{ $totalDays }} in total">
@for ($v = 0; $v <= $top; $v += $step)
@php $y = $padT + $plotH - ($v / $top) * $plotH; @endphp
<line class="{{ $v === 0 ? 'baseline' : 'grid-line' }}" x1="{{ $padL }}" x2="{{ $W }}" y1="{{ $y }}" y2="{{ $y }}"/>
<text class="axis-label" x="{{ $padL - 8 }}" y="{{ $y + 3.5 }}" text-anchor="end">{{ $v }}</text>
@endfor
@foreach ($days as $i => $d)
@php
    $h = $d['count'] ? max(4, ($d['count'] / $top) * $plotH) : 0;
    $x = $padL + $i * $slot + ($slot - $bw) / 2;
    $yTop = $padT + $plotH - $h;
    $r = min(4, $h);
    $isToday = $d['date']->isToday();
@endphp
<rect class="hit" x="{{ $padL + $i * $slot }}" y="{{ $padT }}" width="{{ $slot }}" height="{{ $plotH }}" data-v="{{ $d['count'] }}" data-l="{{ $d['date']->format('D, j M') }}"/>
<path class="bar {{ $isToday ? 'is-today' : '' }}" style="--b:{{ $i }}" d="M{{ $x }},{{ $padT + $plotH }} V{{ $yTop + $r }} Q{{ $x }},{{ $yTop }} {{ $x + $r }},{{ $yTop }} H{{ $x + $bw - $r }} Q{{ $x + $bw }},{{ $yTop }} {{ $x + $bw }},{{ $yTop + $r }} V{{ $padT + $plotH }} Z"/>
@if ($i % 2 === 1 || $isToday)
<text class="axis-label" x="{{ $x + $bw / 2 }}" y="{{ $H - 6 }}" text-anchor="middle">{{ $isToday ? 'Today' : $d['date']->format('j M') }}</text>
@endif
@endforeach
</svg>
<div class="chart-tip"></div>
@if ($totalDays === 0)
<div style="position:absolute;inset:0;display:grid;place-items:center;color:var(--muted);font-weight:600">No enquiries in the last 14 days yet.</div>
@endif
</div>
</div>
</div>

<div class="card">
<div class="card__head"><div><h2>SEO health</h2><p>{{ $grades['total'] }} URLs scored on 10+ checks</p></div><div class="actions"><a class="btn btn--ghost btn--sm" href="{{ route('admin.seo') }}">Details</a></div></div>
<div class="card__body">
<div style="display:flex;align-items:center;gap:20px">
<span class="score score--xl score--{{ $avgGrade }}" style="--v:{{ $stats['seo_avg'] }}"><span>{{ $stats['seo_avg'] }}<small>AVERAGE</small></span></span>
<div style="flex:1;min-width:0">
<div class="segbar" role="img" aria-label="{{ $grades['good'] }} good, {{ $grades['ok'] }} fair, {{ $grades['poor'] }} poor">
@if ($grades['good'])<span class="s-good" style="--f:{{ $grades['good'] }}"></span>@endif
@if ($grades['ok'])<span class="s-ok" style="--f:{{ $grades['ok'] }}"></span>@endif
@if ($grades['poor'])<span class="s-poor" style="--f:{{ $grades['poor'] }}"></span>@endif
</div>
<div class="legend">
<span><i style="background:#16a34a"></i>✓ Good <b>{{ $grades['good'] }}</b></span>
<span><i style="background:#f59e0b"></i>! Fair <b>{{ $grades['ok'] }}</b></span>
<span><i style="background:#dc2626"></i>× Poor <b>{{ $grades['poor'] }}</b></span>
</div>
</div>
</div>
<div class="label" style="margin:22px 0 4px">Needs attention</div>
<ul class="list-plain">
@foreach ($needsWork as $n)
<li><span class="score score--{{ $n['grade'] }}" style="--v:{{ $n['score'] }};width:36px;height:36px;font-size:11.5px"><span>{{ $n['score'] }}</span></span><div style="min-width:0;flex:1"><div style="font-weight:650;color:var(--ink);white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $n['name'] }}</div><div class="muted" style="font-size:12px">{{ $n['type'] }} · {{ $n['issues'] }} {{ \Illuminate\Support\Str::plural('suggestion', $n['issues']) }}</div></div><a class="btn btn--ghost btn--sm" href="{{ $n['edit'] }}">Fix</a></li>
@endforeach
</ul>
</div>
</div>
</div>

<div class="grid grid--wide">
<div class="card">
<div class="card__head"><div><h2>Latest enquiries</h2><p>Newest first · unread highlighted</p></div><div class="actions"><a class="btn btn--ghost btn--sm" href="{{ route('admin.enquiries.index') }}">Open inbox</a></div></div>
<div class="card__body card__body--flush table-wrap">
@if ($recentEnquiries->isEmpty())
<div class="empty"><svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m2 7 10 6 10-6"/></svg>No enquiries yet — they appear here the moment someone submits a form.</div>
@else
<table class="table">
<thead><tr><th>Contact</th><th class="hide-sm">Form</th><th class="hide-sm">Country</th><th>Received</th></tr></thead>
<tbody>
@foreach ($recentEnquiries as $e)
<tr class="{{ $e->is_read ? '' : 'is-unread' }}">
<td><a class="title" href="{{ route('admin.enquiries.show', $e) }}">{{ $e->name }}</a><div class="sub">{{ $e->email }} · {{ $e->phone }}</div></td>
<td class="hide-sm">{{ $e->formLabel() }}</td>
<td class="hide-sm">{{ $e->country }}</td>
<td style="white-space:nowrap">{{ $e->created_at->diffForHumans() }}</td>
</tr>
@endforeach
</tbody>
</table>
@endif
</div>
</div>

<div class="card">
<div class="card__head"><div><h2>Where enquiries come from</h2><p>All-time, by website form</p></div></div>
<div class="card__body">
@php $formMax = max(1, $byForm->max('count')); @endphp
<div class="hbars">
@foreach ($byForm as $f)
<div class="hbar__row"><div class="hbar__top"><span>{{ $f['label'] }}</span><b>{{ $f['count'] }}</b></div><div class="hbar__track"><div class="hbar__fill" style="--w:{{ $f['count'] ? max(3, round($f['count'] / $formMax * 100)) : 0 }}"></div></div></div>
@endforeach
</div>
</div>
</div>
</div>

<div class="grid grid--3">
<div class="card">
<div class="card__head"><div><h2>Most-read articles</h2><p>Visitor reads (admin views not counted)</p></div></div>
<div class="card__body" style="padding-top:6px;padding-bottom:6px">
<ul class="list-plain">
@forelse ($topPosts as $i => $p)
<li><img class="thumb" src="{{ $p->imageUrl() }}" alt=""/><div style="min-width:0;flex:1"><a href="{{ route('admin.posts.edit', $p) }}" style="font-weight:650;color:var(--ink);display:block;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $p->title }}</a><div class="muted" style="font-size:12px">{{ number_format($p->views) }} {{ \Illuminate\Support\Str::plural('read', $p->views) }} · {{ $p->category }}</div></div></li>
@empty
<li class="muted">No published posts yet.</li>
@endforelse
</ul>
</div>
</div>
<div class="card">
<div class="card__head"><div><h2>SEO setup</h2><p>{{ $checklistDone }} of {{ count($checklist) }} complete</p></div></div>
<div class="card__body" style="padding-top:12px">
<div class="progress"><i style="--w:{{ round($checklistDone / count($checklist) * 100) }}"></i></div>
<ul class="checks" style="margin-top:6px">
@foreach ($checklist as [$label, $done])
<li><span class="dot dot--{{ $done ? 'pass' : 'warn' }}">{{ $done ? '✓' : '!' }}</span><div><strong>{{ $label }}</strong>@unless ($done)<small><a href="{{ route('admin.settings.edit') }}">Set up in Global SEO Settings →</a></small>@endunless</div></li>
@endforeach
</ul>
</div>
</div>
<div class="card">
<div class="card__head"><div><h2>Quick actions</h2><p>Jump straight in</p></div></div>
<div class="card__body">
<div class="quick">
<a href="{{ route('admin.posts.create') }}"><span class="ico-circle"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg></span>New article</a>
<a href="{{ route('admin.pages.index') }}"><span class="ico-circle"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/></svg></span>Page SEO</a>
<a href="{{ route('admin.settings.edit') }}"><span class="ico-circle"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="3"/><path d="M12 1v3M12 20v3M4.2 4.2l2.1 2.1M17.7 17.7l2.1 2.1M1 12h3M20 12h3M4.2 19.8l2.1-2.1M17.7 6.3l2.1-2.1"/></svg></span>SEO settings</a>
<a href="{{ route('sitemap') }}" target="_blank" rel="noopener"><span class="ico-circle"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3a15 15 0 0 1 0 18 15 15 0 0 1 0-18z"/></svg></span>Sitemap</a>
<a href="{{ url('/') }}" target="_blank" rel="noopener"><span class="ico-circle"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6M15 3h6v6M10 14 21 3"/></svg></span>View website</a>
<a href="http://localhost/phpmyadmin/" target="_blank" rel="noopener"><span class="ico-circle"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M3 5v14c0 1.7 4 3 9 3s9-1.3 9-3V5M3 12c0 1.7 4 3 9 3s9-1.3 9-3"/></svg></span>phpMyAdmin</a>
</div>
<div class="label" style="margin:20px 0 4px">Recently edited</div>
<ul class="list-plain">
@foreach ($recentPosts->take(3) as $p)
<li style="padding:8px 0"><a href="{{ route('admin.posts.edit', $p) }}" style="flex:1;min-width:0;font-weight:600;color:var(--ink);white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $p->title }}</a><span class="muted" style="font-size:12px;white-space:nowrap">{{ $p->updated_at->diffForHumans(null, true) }}</span></li>
@endforeach
</ul>
</div>
</div>
</div>
@endsection
