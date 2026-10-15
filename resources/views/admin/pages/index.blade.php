@extends('admin.layout')
@section('title', 'Pages SEO')
@section('crumb', 'Super Admin / Pages')

@section('content')
<div class="card">
<div class="card__head"><div><h2>All website pages</h2><p>Every page of the website. Click a page to edit its SEO title, description, social card, indexing and structured data.</p></div></div>
<div class="card__body card__body--flush table-wrap">
<table class="table">
<thead><tr><th>Score</th><th>Page</th><th class="hide-sm">SEO title</th><th class="hide-sm">Focus keyword</th><th>Indexing</th><th></th></tr></thead>
<tbody>
@foreach ($pages as $row)
@php $p = $row['page']; $a = $row['analysis']; @endphp
<tr>
<td><span class="score score--{{ $a['grade'] }}" style="--v:{{ $a['score'] }}"><span>{{ $a['score'] }}</span></span></td>
<td><div class="title">{{ $p->name }}</div><div class="sub">{{ $p->path() ?? 'Shown for unknown URLs (404)' }}</div></td>
<td class="hide-sm"><div style="max-width:340px">{{ \Illuminate\Support\Str::limit($p->meta_title, 70) ?: '—' }}</div><div class="sub">{{ mb_strlen((string) $p->meta_title) }} chars · description {{ mb_strlen((string) $p->meta_description) }} chars</div></td>
<td class="hide-sm">{{ $p->focus_keyword ?: '—' }}</td>
<td>@if ($p->isIndexable())<span class="badge badge--good">index</span>@else<span class="badge badge--draft">noindex</span>@endif</td>
<td class="num">
@if ($p->path())<a class="btn btn--ghost btn--sm" href="{{ url($p->path()) }}" target="_blank" rel="noopener">View</a>@endif
<a class="btn btn--primary btn--sm" href="{{ route('admin.pages.edit', $p) }}">Edit SEO</a>
</td>
</tr>
@endforeach
</tbody>
</table>
</div>
</div>
@endsection
