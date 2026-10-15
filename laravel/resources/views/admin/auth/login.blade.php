<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<meta name="robots" content="noindex, nofollow"/>
<title>Super Admin Login · Diverse Pathwais</title>
<link rel="icon" href="{{ asset('assets/img/DIVERSE-PATHWAIS-main-Logo-1024x534.webp') }}"/>
<link rel="preconnect" href="https://fonts.googleapis.com"/>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
<link rel="stylesheet" href="{{ asset('assets/admin/admin.css') }}?v=3"/>
</head>
<body>
<div class="auth">
<div class="auth__art">
<span class="auth__logo"><img src="{{ asset('assets/img/DIVERSE-PATHWAIS-main-Logo-1024x534.webp') }}" alt="Diverse Pathwais PVT LTD."/></span>
<div>
<h2>Manage your website, blogs and <em>SEO</em> from one place.</h2>
<p>Edit meta titles, descriptions, social cards and structured data for every page and article — and track every enquiry that comes in.</p>
</div>
<p style="font-size:12px;opacity:.6">&copy; {{ date('Y') }} Diverse Pathwais PVT LTD.</p>
</div>
<div class="auth__form">
<form class="auth__box" method="post" action="{{ route('admin.login.attempt') }}" novalidate>
@csrf
<h1>Super Admin Login</h1>
<p>Sign in to continue to the admin panel.</p>
@if (session('status'))<div class="alert alert--success">{{ session('status') }}</div>@endif
<div class="field {{ $errors->has('email') ? 'has-error' : '' }}">
<label for="email">Email address</label>
<input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="username" required autofocus/>
@error('email')<span class="error">{{ $message }}</span>@enderror
</div>
<div class="field {{ $errors->has('password') ? 'has-error' : '' }}">
<label for="password">Password</label>
<input id="password" name="password" type="password" autocomplete="current-password" required/>
@error('password')<span class="error">{{ $message }}</span>@enderror
</div>
<label class="check"><input type="checkbox" name="remember" value="1"/> Keep me signed in</label>
<button class="btn btn--primary btn--block" type="submit" style="padding:12px">Sign in</button>
<a href="{{ url('/') }}" class="muted" style="text-align:center;font-size:13px">&larr; Back to website</a>
</form>
</div>
</div>
</body>
</html>
