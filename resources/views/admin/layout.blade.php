<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<meta name="csrf-token" content="{{ csrf_token() }}"/>
<meta name="robots" content="noindex, nofollow"/>
<meta name="theme-color" content="#06172b"/>
<title>@yield('title', 'Dashboard') · Super Admin · Diverse Pathwais</title>
<link rel="icon" href="{{ asset('assets/img/DIVERSE-PATHWAIS-main-Logo-1024x534.webp') }}"/>
<link rel="preconnect" href="https://fonts.googleapis.com"/>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
@stack('head')
<link rel="stylesheet" href="{{ asset('assets/admin/admin.css') }}?v=7"/>
<script>try { if (localStorage.getItem('dp-admin-collapsed') === '1') document.documentElement.classList.add('side-collapsed'); } catch (e) {}</script>
</head>
<body>
@php
    $user = auth()->user();
    $unreadList = \App\Models\Enquiry::where('is_read', false)->latest()->take(5)->get();
    $unread = \App\Models\Enquiry::where('is_read', false)->count();
    $ic = [
        'dash' => '<path d="M3 13h8V3H3zM13 21h8V11h-8zM3 21h8v-6H3zM13 3v6h8V3z"/>',
        'seo' => '<path d="M3 3v18h18"/><path d="m7 15 4-4 3 3 6-6"/>',
        'pages' => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M8 13h8M8 17h5"/>',
        'blog' => '<path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 1 1 3 3L7 19l-4 1 1-4z"/>',
        'mail' => '<rect x="2" y="4" width="20" height="16" rx="2"/><path d="m2 7 10 6 10-6"/>',
        'cog' => '<circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 1 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 1 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68 1.65 1.65 0 0 0 10 3.17V3a2 2 0 1 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 1 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/>',
        'user' => '<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>',
        'ext' => '<path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6M15 3h6v6M10 14 21 3"/>',
        'plus' => '<path d="M12 5v14M5 12h14"/>',
    ];
    $nav = [
        ['Manage', [
            ['admin.dashboard', 'Dashboard', 'admin.dashboard', 'dash'],
            ['admin.seo', 'SEO Dashboard', 'admin.seo', 'seo'],
            ['admin.pages.index', 'Pages SEO', 'admin.pages.*', 'pages'],
            ['admin.posts.index', 'Blogs', 'admin.posts.*', 'blog'],
            ['admin.enquiries.index', 'Enquiries', 'admin.enquiries.*', 'mail'],
        ]],
        ['Settings', [
            ['admin.settings.edit', 'Global SEO Settings', 'admin.settings.*', 'cog'],
            ['admin.account.edit', 'My Account', 'admin.account.*', 'user'],
        ]],
    ];
    // command palette index
    $cmd = [];
    foreach ($nav as [$group, $items]) {
        foreach ($items as [$route, $label, , $icon]) {
            $cmd[] = ['g' => 'Go to', 't' => $label, 'u' => route($route), 'i' => $icon];
        }
    }
    $cmd[] = ['g' => 'Actions', 't' => 'Write a new blog post', 'u' => route('admin.posts.create'), 'i' => 'plus'];
    $cmd[] = ['g' => 'Actions', 't' => 'Open the website', 'u' => url('/'), 'i' => 'ext', 'n' => 1];
    $cmd[] = ['g' => 'Actions', 't' => 'View sitemap.xml', 'u' => route('sitemap'), 'i' => 'ext', 'n' => 1];
    foreach (\App\Models\Page::orderBy('name')->get(['id', 'name', 'slug']) as $p) {
        $cmd[] = ['g' => 'Page SEO', 't' => $p->name, 's' => $p->path() ?? '404', 'u' => route('admin.pages.edit', $p), 'i' => 'pages'];
    }
    foreach (\App\Models\Post::latest('updated_at')->take(50)->get(['id', 'title', 'slug']) as $p) {
        $cmd[] = ['g' => 'Blog posts', 't' => $p->title, 's' => '/blog/'.$p->slug, 'u' => route('admin.posts.edit', $p), 'i' => 'blog'];
    }
@endphp
<div class="nprogress" data-nprogress></div>
<div class="adm" data-shell>
<div class="adm-scrim" data-toggle-side></div>
<aside class="adm-side">
<a class="adm-brand" href="{{ route('admin.dashboard') }}">
<span class="adm-brand__logo"><img src="{{ asset('assets/img/DIVERSE-PATHWAIS-main-Logo-1024x534.webp') }}" alt=""/></span>
<span class="adm-brand__text"><strong>Diverse Pathwais</strong><small>Control Centre</small></span>
</a>
<nav class="adm-nav" aria-label="Admin" data-nav>
<span class="adm-nav__ind" data-nav-ind></span>
@foreach ($nav as [$group, $items])
<span class="adm-nav__label">{{ $group }}</span>
@foreach ($items as [$route, $label, $pattern, $icon])
<a href="{{ route($route) }}" class="{{ request()->routeIs($pattern) ? 'is-active' : '' }}" title="{{ $label }}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">{!! $ic[$icon] !!}</svg><span>{{ $label }}</span>@if ($route === 'admin.enquiries.index' && $unread)<b class="count">{{ $unread }}</b>@endif</a>
@endforeach
@endforeach
<a href="{{ url('/') }}" target="_blank" rel="noopener" title="View website"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">{!! $ic['ext'] !!}</svg><span>View Website</span></a>
</nav>
<div class="adm-side__foot">
<div class="adm-usercard">
<span class="avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
<span class="adm-usercard__meta"><strong>{{ $user->name }}</strong><small>{{ $user->email }}</small></span>
</div>
<button class="adm-collapse" type="button" data-collapse aria-label="Collapse sidebar"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg><span>Collapse</span></button>
</div>
</aside>

<div class="adm-main">
<header class="adm-top" data-top>
<button class="icon-btn adm-burger" type="button" data-toggle-side aria-label="Open menu"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M3 6h18M3 12h18M3 18h12"/></svg></button>
<div class="adm-top__title">
<div class="adm-top__crumb">@yield('crumb', 'Super Admin')</div>
<h1>@yield('title', 'Dashboard')</h1>
</div>
<div class="adm-top__actions">
<button class="cmdk-trigger" type="button" data-cmdk-open aria-label="Search (Ctrl+K)"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg><span>Search or jump to…</span><kbd>Ctrl K</kbd></button>
@yield('actions')
<div class="drop" data-drop>
<button class="icon-btn" type="button" data-drop-toggle aria-label="Notifications" aria-expanded="false"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8a6 6 0 0 0-12 0c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.7 21a2 2 0 0 1-3.4 0"/></svg>@if ($unread)<span class="dotcount">{{ $unread }}</span>@endif</button>
<div class="drop__menu" role="menu">
<div class="drop__head">New enquiries @if ($unread)<span class="badge badge--ok">{{ $unread }} unread</span>@endif</div>
@forelse ($unreadList as $n)
<a class="drop__item" href="{{ route('admin.enquiries.show', $n) }}"><span class="ico-circle"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">{!! $ic['mail'] !!}</svg></span><span><strong>{{ $n->name }}</strong><small>{{ $n->formLabel() }} · {{ $n->country }} · {{ $n->created_at->diffForHumans() }}</small></span></a>
@empty
<div class="drop__empty">You're all caught up ✨</div>
@endforelse
<a class="drop__foot" href="{{ route('admin.enquiries.index') }}">Open enquiry inbox →</a>
</div>
</div>
<div class="drop" data-drop>
<button class="icon-btn" type="button" data-drop-toggle aria-label="Account menu" aria-expanded="false" style="padding:0;border:0;background:none;box-shadow:none"><span class="avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</span></button>
<div class="drop__menu" role="menu" style="width:250px">
<div class="drop__head" style="display:block">{{ $user->name }}<div class="muted" style="font-weight:500;font-size:12px">{{ $user->email }}</div></div>
<a class="drop__item" href="{{ route('admin.account.edit') }}"><span class="ico-circle" style="background:var(--navy-50);color:var(--navy)"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">{!! $ic['user'] !!}</svg></span><span><strong>My account</strong><small>Profile &amp; password</small></span></a>
<form method="post" action="{{ route('admin.logout') }}">@csrf<button class="btn btn--ghost btn--block" type="submit" style="margin-top:6px">Log out</button></form>
</div>
</div>
</div>
</header>
<main class="adm-content" data-content>
@if ($errors->any())
<div class="alert alert--error" role="alert"><div>Please fix the following:<ul>@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div></div>
@endif
@yield('content')
</main>
</div>
</div>

<div class="cmdk" data-cmdk aria-hidden="true">
<div class="cmdk__box" role="dialog" aria-label="Command palette">
<div class="cmdk__input"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg><input type="text" placeholder="Search pages, blog posts, settings…" data-cmdk-input aria-label="Search"/><kbd>Esc</kbd></div>
<div class="cmdk__list" data-cmdk-list></div>
<div class="cmdk__foot"><span><kbd>↑</kbd> <kbd>↓</kbd> navigate</span><span><kbd>Enter</kbd> open</span><span><kbd>Esc</kbd> close</span></div>
</div>
</div>
<script type="application/json" id="cmdk-data">@json($cmd)</script>
<script type="application/json" id="cmdk-icons">@json($ic)</script>
<div class="toasts" data-toasts>
@if (session('status'))
<div class="toast" role="status"><span class="toast__ic"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg></span><div><strong>{{ session('status') }}</strong><small>Just now</small></div><span class="toast__bar"></span></div>
@endif
</div>
@stack('scripts')
<script src="{{ asset('assets/admin/admin.js') }}?v=7"></script>
</body>
</html>
