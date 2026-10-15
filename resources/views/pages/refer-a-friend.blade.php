@extends('layouts.site')

@section('content')
<section class="page-hero" style="background-image: url('{{ asset('assets/img/banners/banner-about.jpg') }}');">
<div class="shell">
<nav class="breadcrumb" aria-label="Breadcrumb"><a href="{{ url('/') }}">Home</a><span>/</span>Refer a Friend</nav>
<div class="page-hero__content">
<span class="page-hero__eyebrow" data-anim="up">COMMUNITY & REWARDS</span>
<h1 class="page-hero__title" data-anim="up">REFER A FRIEND</h1>
<p class="page-hero__lead" data-anim="up" style="--d:110ms">Help your friends, family, and colleagues achieve their global aspirations with trusted immigration experts.</p>
</div>
</div>
</section><section class="section section--tight">
<div class="shell"><div class="prose" data-anim="up" style="margin:0 auto">
<p>Do you know a friend, family member, or colleague interested in traveling or settling abroad?</p>
<p>Simply use our &ldquo;Refer a Friend&rdquo; option by filling in their details below. Our team will connect with them to provide guidance and make their journey easier.</p>
</div></div>
</section><section class="section form-band" id="enquiry">
<div class="shell">
<div class="form-card" data-anim="up" style="max-width:860px;margin:0 auto">
<div class="center" style="margin-bottom:2.25rem">
<span class="eyebrow">Get started</span>
<h2>Refer a Friend</h2>
<p class="lead" style="margin:.85rem auto 0;max-width:520px">Fill in their details below and our team will reach out to them.</p>
</div>
<!-- Front-end only: wire the `action`/`method` below to your mail handler or CRM endpoint. -->
<form data-enquiry-form id="refer-form" action="{{ route('enquiry.store') }}" method="post" novalidate>
@csrf
<input type="hidden" name="form" value="refer-form"/>
<div class="form-grid">
<div class="field"><label for="refer-form-name">Name</label><input id="refer-form-name" name="name" type="text" autocomplete="name" required/><span class="error"></span></div>
<div class="field"><label for="refer-form-number">Number</label><input id="refer-form-number" name="number" type="tel" autocomplete="tel" required/><span class="error"></span></div>
<div class="field"><label for="refer-form-country">Country of Interest</label>
<select id="refer-form-country" name="country" required>
<option value="">Select a country</option>
<option>Canada</option><option>Australia</option><option>USA</option>
<option>United Kingdom</option><option>New Zealand</option><option>Europe</option>
<option>Other</option>
</select><span class="error"></span></div>
<div class="field"><label for="refer-form-email">Email</label><input id="refer-form-email" name="email" type="email" autocomplete="email" required/><span class="error"></span></div>
<div class="field field--full"><label for="refer-form-message">Message</label><textarea id="refer-form-message" name="message" rows="4"></textarea><span class="error"></span></div>
</div>
<button class="btn btn--primary btn--lg btn--block" type="submit" style="margin-top:1.75rem">Send Referral <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14m-7-7 7 7-7 7"/></svg></button>
<p class="form-status" role="status" aria-live="polite"></p>
</form>
</div>
</div>
</section>
@endsection
