<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<meta name="robots" content="noindex, nofollow"/>
<meta name="theme-color" content="#06172b"/>
<title>Super Admin Login · Diverse Pathwais</title>
<link rel="icon" href="{{ asset('assets/img/DIVERSE-PATHWAIS-main-Logo-1024x534.webp') }}"/>
<link rel="preconnect" href="https://fonts.googleapis.com"/>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
<link rel="stylesheet" href="{{ asset('assets/admin/admin.css') }}?v=7"/>
</head>
<body>
@php
    $hour = (int) now()->format('G');
    $greeting = $hour < 12 ? 'Good morning' : ($hour < 17 ? 'Good afternoon' : 'Good evening');
    $words = ['Run', 'your', 'website,', 'blog', 'and', '<em>SEO</em>', 'from', 'one', 'cockpit.'];
@endphp
<div class="auth">
<section class="auth__art" data-parallax>
<div class="auth__glow"></div>
<div class="auth__grid auth__layer" data-depth="6"></div>
<svg class="auth__map auth__layer" data-depth="14" viewBox="0 0 800 600" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
<defs>
<linearGradient id="goldline" x1="0" x2="1"><stop offset="0" stop-color="#f5ad16" stop-opacity=".1"/><stop offset=".5" stop-color="#ffd27a"/><stop offset="1" stop-color="#f5ad16"/></linearGradient>
<path id="p1" d="M520 330 C 430 170, 260 140, 170 210"/>
<path id="p2" d="M520 330 C 470 240, 380 200, 345 190"/>
<path id="p3" d="M520 330 C 620 370, 690 430, 705 470"/>
</defs>
<path class="r" d="M170 210 C 230 120, 330 110, 345 190"/>
<path class="r" d="M345 190 C 420 260, 560 470, 705 470"/>
<path class="r" d="M170 210 C 260 360, 520 520, 705 470"/>
<path class="r" d="M520 330 C 560 260, 640 230, 690 250"/>
<use href="#p1" class="r-live"/>
<use href="#p2" class="r-live d2"/>
<use href="#p3" class="r-live d3"/>
<circle class="city" cx="170" cy="210" r="3.5"/><text x="150" y="236">YYZ</text>
<circle class="city" cx="345" cy="190" r="3.5"/><text x="330" y="176">LHR</text>
<circle class="city" cx="705" cy="470" r="3.5"/><text x="690" y="496">SYD</text>
<circle class="city" cx="690" cy="250" r="3"/><text x="676" y="236">SIN</text>
<circle class="city-gold" cx="520" cy="330" r="5"/><circle class="halo" cx="520" cy="330" r="6"/><circle class="halo h2" cx="520" cy="330" r="6"/><text x="503" y="358" style="fill:#f5ad16">DEL</text>
<g class="plane"><path d="M0-7 1.4-2.2 7 1v1.6L1.4.6V4.2l1.9 1.4V7L0 6 -3.3 7V5.6l1.9-1.4V.6L-7 2.6V1L-1.4-2.2Z" transform="rotate(90)"/><animateMotion dur="7s" repeatCount="indefinite" rotate="auto" keyPoints="0;1" keyTimes="0;1" calcMode="spline" keySplines=".45 0 .55 1"><mpath href="#p1"/></animateMotion></g>
<g class="plane"><path d="M0-7 1.4-2.2 7 1v1.6L1.4.6V4.2l1.9 1.4V7L0 6 -3.3 7V5.6l1.9-1.4V.6L-7 2.6V1L-1.4-2.2Z" transform="rotate(90)"/><animateMotion dur="9s" begin="2s" repeatCount="indefinite" rotate="auto" calcMode="spline" keyPoints="0;1" keyTimes="0;1" keySplines=".45 0 .55 1"><mpath href="#p3"/></animateMotion></g>
</svg>

<a class="auth__logo" href="{{ url('/') }}" aria-label="Diverse Pathwais website">
<span><img src="{{ asset('assets/img/DIVERSE-PATHWAIS-main-Logo-1024x534.webp') }}" alt="Diverse Pathwais PVT LTD." width="66" height="34"/></span>
<div><b>Diverse Pathwais</b><small>Control Centre</small></div>
</a>

<div class="auth__copy">
<span class="auth__kicker">Super Admin</span>
<h2>@foreach ($words as $i => $w)<span class="w" style="--w:{{ $i }}">{!! $w !!}</span> @endforeach</h2>
<p>Fine-tune <span class="auth__rotator" data-rotator><span class="is-on">meta titles &amp; descriptions</span><span>social share cards</span><span>blog posts &amp; slugs</span><span>every enquiry that lands</span></span><br/>for every page of the website, in real time.</p>
<div class="auth__chips">
<span class="chip" style="--i:0"><i><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="m7 15 4-4 3 3 6-6"/></svg></i>Live SEO scoring</span>
<span class="chip" style="--i:1"><i><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 1 1 3 3L7 19l-4 1 1-4z"/></svg></i>Blog studio</span>
<span class="chip" style="--i:2"><i><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m2 7 10 6 10-6"/></svg></i>Enquiry inbox</span>
<span class="chip" style="--i:3"><i><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3a15 15 0 0 1 0 18 15 15 0 0 1 0-18z"/></svg></i>Sitemap &amp; schema</span>
</div>
</div>
<div class="auth__foot"><span>&copy; {{ date('Y') }} Diverse Pathwais PVT LTD.</span><span>DEL → YYZ · LHR · SYD</span></div>
</section>

<section class="auth__form">
<form class="auth__box {{ $errors->any() ? 'is-shake' : '' }}" method="post" action="{{ route('admin.login.attempt') }}" novalidate data-login>
@csrf
<span class="auth__badge" style="--i:0"><i><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="11" width="16" height="10" rx="2"/><path d="M8 11V7a4 4 0 0 1 8 0v4"/></svg></i>Restricted area</span>
<h1 style="--i:1">{{ $greeting }}.<span>Sign in to the Diverse Pathwais control centre.</span></h1>
@if (session('status'))<div class="auth__status" style="--i:2">{{ session('status') }}</div>@endif

<div class="ff {{ $errors->has('email') ? 'has-error' : '' }}" style="--i:2">
<input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="username" placeholder=" " required autofocus/>
<label for="email">Email address</label>
<svg class="ff__ic" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m2 7 10 6 10-6"/></svg>
@error('email')<div class="ff__msg"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><circle cx="12" cy="12" r="9"/><path d="M12 8v5M12 16h.01"/></svg>{{ $message }}</div>@enderror
</div>

<div class="ff {{ $errors->has('password') ? 'has-error' : '' }}" style="--i:3">
<input id="password" name="password" type="password" autocomplete="current-password" placeholder=" " required/>
<label for="password">Password</label>
<svg class="ff__ic" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="4" y="11" width="16" height="10" rx="2"/><path d="M8 11V7a4 4 0 0 1 8 0v4"/></svg>
<button class="ff__eye" type="button" data-eye aria-label="Show password" aria-pressed="false"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg></button>
<div class="ff__caps" data-caps><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M12 4 4 13h5v7h6v-7h5z"/></svg>Caps Lock is on</div>
@error('password')<div class="ff__msg">{{ $message }}</div>@enderror
</div>

<label class="switch" style="--i:4"><input type="checkbox" name="remember" value="1" @checked(old('remember'))/><i></i>Keep me signed in on this device</label>

<button class="btn btn--primary btn--block auth__submit" type="submit" style="--i:5">Sign in to dashboard <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14m-6-6 6 6-6 6"/></svg></button>
<div class="auth__secure" style="--i:6"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg>Encrypted session · 5 attempts per minute</div>
<a class="auth__back" href="{{ url('/') }}" style="--i:7"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M19 12H5m6-6-6 6 6 6"/></svg>Back to website</a>
</form>
</section>
</div>
<script src="{{ asset('assets/admin/admin.js') }}?v=7"></script>
</body>
</html>
