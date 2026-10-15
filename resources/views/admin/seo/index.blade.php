@extends('admin.layout')
@section('title', 'SEO Dashboard')
@section('crumb', 'Super Admin / SEO')
@section('actions')
<a class="btn btn--ghost" href="{{ route('admin.settings.edit') }}">Global SEO settings</a>
@endsection

@section('content')
<div class="stats">
<div class="stat">
<div class="stat__label">Site-wide SEO score</div>
<div style="display:flex;align-items:center;gap:14px;margin-top:8px">
<span class="score score--lg score--{{ $summary['avg'] >= 80 ? 'good' : ($summary['avg'] >= 50 ? 'ok' : 'poor') }}" style="--v:{{ $summary['avg'] }}"><span>{{ $summary['avg'] }}</span></span>
<div class="stat__meta">Average across {{ $summary['total'] }} URLs<br/>(pages + blog posts)</div>
</div>
</div>
<div class="stat">
<div class="stat__label">Health</div>
<div class="stat__value" style="font-size:22px;display:flex;gap:10px;flex-wrap:wrap;margin-top:12px">
<span class="badge badge--good" style="font-size:13px">{{ $summary['good'] }} good</span>
<span class="badge badge--ok" style="font-size:13px">{{ $summary['ok'] }} fair</span>
<span class="badge badge--poor" style="font-size:13px">{{ $summary['poor'] }} poor</span>
</div>
<div class="stat__meta" style="margin-top:10px">Good ≥ 80 · Fair 50–79 · Poor &lt; 50</div>
</div>
<div class="stat">
<div class="stat__label">Missing data</div>
<div class="stat__value">{{ $summary['missing_desc'] + $summary['missing_kw'] }}</div>
<div class="stat__meta">{{ $summary['missing_desc'] }} without description · {{ $summary['missing_kw'] }} without focus keyword</div>
</div>
<div class="stat">
<div class="stat__label">Hidden from Google</div>
<div class="stat__value">{{ $summary['noindex'] }}</div>
<div class="stat__meta">URLs set to <code>noindex</code></div>
</div>
</div>

<div class="card">
<div class="card__head" style="flex-wrap:wrap">
<div><h2>All URLs</h2><p>Click “Fix” to edit the SEO of any page or blog post.</p></div>
<div class="filters" style="margin-left:auto">
@foreach (['' => 'Everything', 'pages' => 'Pages', 'blogs' => 'Blogs', 'issues' => 'Needs work'] as $key => $label)
<a class="pill {{ (string) $filter === $key ? 'is-active' : '' }}" href="{{ route('admin.seo', array_filter(['filter' => $key])) }}">{{ $label }}</a>
@endforeach
</div>
</div>
<div class="card__body card__body--flush table-wrap">
<table class="table">
<thead><tr><th>Score</th><th>URL</th><th class="hide-sm">Title</th><th class="hide-sm">Description</th><th class="hide-sm">Keyword</th><th>Top issue</th><th></th></tr></thead>
<tbody>
@forelse ($rows as $r)
@php
    $top = collect($r['checks'])->first(fn ($c) => $c[1] === 'fail') ?? collect($r['checks'])->first(fn ($c) => $c[1] === 'warn');
    $tl = mb_strlen((string) $r['title']); $dl = mb_strlen((string) $r['description']);
@endphp
<tr>
<td><span class="score score--{{ $r['grade'] }}" style="--v:{{ $r['score'] }}"><span>{{ $r['score'] }}</span></span></td>
<td><div class="title">{{ \Illuminate\Support\Str::limit($r['name'], 48) }}</div><div class="sub"><span class="badge" style="padding:1px 7px;font-size:10.5px">{{ $r['type'] }}</span> {{ $r['path'] }} @unless ($r['live'])<span class="badge badge--draft" style="padding:1px 7px;font-size:10.5px">not live</span>@endunless @unless ($r['indexable'])<span class="badge badge--draft" style="padding:1px 7px;font-size:10.5px">noindex</span>@endunless</div></td>
<td class="hide-sm"><span class="badge badge--{{ $tl === 0 ? 'poor' : (($tl >= 30 && $tl <= 65) ? 'good' : 'ok') }}">{{ $tl }}</span></td>
<td class="hide-sm"><span class="badge badge--{{ $dl === 0 ? 'poor' : (($dl >= 70 && $dl <= 165) ? 'good' : 'ok') }}">{{ $dl }}</span></td>
<td class="hide-sm">{{ $r['keyword'] ?: '—' }}</td>
<td style="max-width:280px">@if ($top)<strong style="font-size:12.5px;color:var(--ink)">{{ $top[0] }}</strong><div class="sub" style="word-break:normal">{{ $top[2] }}</div>@else<span class="badge badge--good">All checks passed</span>@endif</td>
<td class="num">@if ($r['url'])<a class="btn btn--ghost btn--sm" href="{{ $r['url'] }}" target="_blank" rel="noopener">View</a>@endif <a class="btn btn--primary btn--sm" href="{{ $r['edit'] }}">Fix</a></td>
</tr>
@empty
<tr><td colspan="7" class="empty">Nothing matches this filter. 🎉</td></tr>
@endforelse
</tbody>
</table>
</div>
</div>
@endsection
