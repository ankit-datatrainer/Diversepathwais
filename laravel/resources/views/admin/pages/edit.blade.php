@extends('admin.layout')
@section('title', 'SEO · '.$page->name)
@section('crumb')
<a href="{{ route('admin.pages.index') }}">Pages SEO</a> / {{ $page->name }}
@endsection
@section('actions')
@if ($page->path())<a class="btn btn--ghost" href="{{ url($page->path()) }}" target="_blank" rel="noopener">View page</a>@endif
@endsection

@section('content')
@php
    $site = \App\Models\Setting::get('site_name');
    $fallbackTitle = $page->name.' | '.$site;
@endphp
<form method="post" action="{{ route('admin.pages.update', $page) }}" enctype="multipart/form-data">
@csrf
@method('PUT')
<div class="grid grid--main">
<div class="grid">
<div class="card">
<nav class="tabs" data-tabs>
<button type="button" class="is-active" data-tab="search">Google search</button>
<button type="button" data-tab="social">Social sharing</button>
<button type="button" data-tab="advanced">Advanced</button>
</nav>
@php
    $extraAdvanced = view('admin.pages.sitemap-fields', ['page' => $page])->render();
@endphp
@include('admin.partials.seo-fields', ['model' => $page, 'fallbackTitle' => $fallbackTitle, 'extraAdvanced' => $extraAdvanced])
</div>
<div class="form-actions">
<button class="btn btn--primary" type="submit">Save page SEO</button>
<a class="btn btn--ghost" href="{{ route('admin.pages.index') }}">Back to pages</a>
<span class="muted" style="margin-left:auto;font-size:12.5px">Last updated {{ $page->updated_at?->diffForHumans() }}</span>
</div>
</div>
<div class="grid sticky">
@include('admin.partials.seo-preview', [
    'path' => $page->path() ?? '/404',
    'fallbackTitle' => $fallbackTitle,
    'fallbackDesc' => '',
    'analysis' => $analysis,
    'socialImage' => \App\Support\Seo::absolute($page->og_image ?: \App\Models\Setting::get('default_og_image')),
])
</div>
</div>
</form>
@endsection
