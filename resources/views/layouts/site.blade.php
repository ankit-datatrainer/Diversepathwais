@php
    $seo = $seo ?? \App\Support\Seo::forPage('404');
    $activeNav = $activeNav ?? '';
    $isHome = $isHome ?? false;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
@include('partials.seo')
<link rel="icon" href="{{ asset('assets/img/DIVERSE-PATHWAIS-main-Logo-1024x534.webp') }}"/>
<link rel="preconnect" href="https://fonts.googleapis.com"/>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet"/>
@stack('head')
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}"/>
<link rel="stylesheet" href="{{ asset('assets/css/award-motion.css') }}"/>
<link rel="stylesheet" href="{{ asset('assets/css/flight.css') }}"/>
<link rel="stylesheet" href="{{ asset('assets/css/blog.css') }}"/>
<link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}"/>
<script type="importmap">{"imports":{"three":"https://cdn.jsdelivr.net/npm/three@0.170.0/build/three.module.js"}}</script>
<link rel="modulepreload" href="https://cdn.jsdelivr.net/npm/three@0.170.0/build/three.module.js" crossorigin/>
@foreach ($seo['schema'] as $schema)
<script type="application/ld+json">{!! $schema !!}</script>
@endforeach
@include('partials.analytics')
</head>
<body>
@include('partials.loader')
@include('partials.header')
<main id="main">
@yield('content')
</main>
@include('partials.footer')
<script type="module" src="{{ asset('assets/js/flight.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}" defer></script>
@if (!empty($adminEditUrl))
<a class="admin-seo-pill" href="{{ $adminEditUrl }}">Edit SEO</a>
@endif
{!! \App\Models\Setting::get('body_code') !!}
</body>
</html>
