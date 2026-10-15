<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<meta name="csrf-token" content="{{ csrf_token() }}"/>
<meta name="robots" content="noindex, nofollow"/>
<title>@yield('title', 'Dashboard') · Super Admin · Diverse Pathwais</title>
<link rel="icon" href="{{ asset('assets/img/DIVERSE-PATHWAIS-main-Logo-1024x534.webp') }}"/>
<link rel="preconnect" href="https://fonts.googleapis.com"/>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
@stack('head')
<link rel="stylesheet" href="{{ asset('assets/admin/admin.css') }}?v=3"/>
</head>
<body>
@php
    $unread = \App\Models\Enquiry::where('is_read', false)->count();
    $nav = [
        ['admin.dashboard', 'Dashboard', 'admin.dashboard', '<path d="M3 13h8V3H3zM13 21h8V11h-8zM3 21h8v-6H3zM13 3v6h8V3z"/>'],
        ['admin.seo', 'SEO Dashboard', 'admin.seo', '<path d="M3 3v18h18"/><path d="m7 15 4-4 3 3 6-6"/>'],
        ['admin.pages.index', 'Pages SEO', 'admin.pages.*', '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M8 13h8M8 17h5"/>'],
        ['admin.posts.index', 'Blogs', 'admin.posts.*', '<path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 1 1 3 3L7 19l-4 1 1-4z"/>'],
        ['admin.enquiries.index', 'Enquiries', 'admin.enquiries.*', '<rect x="2" y="4" width="20" height="16" rx="2"/><path d="m2 7 10 6 10-6"/>'],
    ];
    $navSettings = [
        ['admin.settings.edit', 'Global SEO Settings', 'admin.settings.*', '<circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 1 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 1 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68 1.65 1.65 0 0 0 10 3.17V3a2 2 0 1 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 1 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/>'],
        ['admin.account.edit', 'My Account', 'admin.account.*', '<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>'],
    ];
@endphp
<div class="adm">
<aside class="adm-side">
<a class="adm-brand" href="{{ route('admin.dashboard') }}">
<span class="adm-brand__logo"><img src="{{ asset('assets/img/DIVERSE-PATHWAIS-main-Logo-1024x534.webp') }}" alt=""/></span>
<span><strong>Diverse Pathwais</strong><small>Super Admin</small></span>
</a>
<nav class="adm-nav" aria-label="Admin">
<span class="adm-nav__label">Manage</span>
@foreach ($nav as [$route, $label, $pattern, $icon])
<a href="{{ route($route) }}" class="{{ request()->routeIs($pattern) ? 'is-active' : '' }}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">{!! $icon !!}</svg>{{ $label }}@if ($route === 'admin.enquiries.index' && $unread)<span class="count">{{ $unread }}</span>@endif</a>
@endforeach
<span class="adm-nav__label">Settings</span>
@foreach ($navSettings as [$route, $label, $pattern, $icon])
<a href="{{ route($route) }}" class="{{ request()->routeIs($pattern) ? 'is-active' : '' }}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">{!! $icon !!}</svg>{{ $label }}</a>
@endforeach
<a href="{{ url('/') }}" target="_blank" rel="noopener"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6M15 3h6v6M10 14 21 3"/></svg>View Website</a>
</nav>
<div class="adm-side__foot">Signed in as <a href="{{ route('admin.account.edit') }}">{{ auth()->user()->email }}</a></div>
</aside>
<div class="adm-main">
<header class="adm-top">
<button class="adm-burger" type="button" data-toggle-side aria-label="Toggle menu"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M3 6h18M3 12h18M3 18h18"/></svg></button>
<div>
<div class="adm-top__crumb">@yield('crumb', 'Super Admin')</div>
<h1>@yield('title', 'Dashboard')</h1>
</div>
<div class="adm-top__actions">
@yield('actions')
<div class="adm-user">
<span class="adm-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
<span>{{ auth()->user()->name }}</span>
<form method="post" action="{{ route('admin.logout') }}" class="inline">@csrf<button class="btn btn--ghost btn--sm" type="submit">Log out</button></form>
</div>
</div>
</header>
<main class="adm-content">
@if (session('status'))
<div class="alert alert--success" role="status">✓ {{ session('status') }}</div>
@endif
@if ($errors->any())
<div class="alert alert--error" role="alert"><div>Please fix the following:<ul>@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div></div>
@endif
@yield('content')
</main>
</div>
</div>
@stack('scripts')
<script src="{{ asset('assets/admin/admin.js') }}?v=2"></script>
</body>
</html>
