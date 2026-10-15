@extends('layouts.site')

@section('content')
<section class="page-hero" style="background-image: url('{{ asset('assets/img/banners/banner-eligibility-assessment.jpg') }}');">
<div class="shell">
<nav class="breadcrumb" aria-label="Breadcrumb"><a href="{{ url('/') }}">Home</a><span>/</span>Eligibility Assessment</nav>
<div class="page-hero__content">
<span class="page-hero__eyebrow" data-anim="up">PROFILE EVALUATION</span>
<h1 class="page-hero__title" data-anim="up">ELIGIBILITY ASSESSMENT</h1>
<p class="page-hero__lead" data-anim="up" style="--d:110ms">Quick online assessment helps determine your visa eligibility with instant result updates.</p>
</div>
</div>
</section><section class="section section--tight">
<div class="shell">
<div class="prose center" data-anim="up" style="max-width:700px;margin:0 auto">
<h2>Check Your Eligibility</h2>
<p>Take our quick online assessment to see if you qualify for a Visitor Visa. Simply register below and get your results instantly.</p>
</div>
</div>
</section><section class="section form-band" id="enquiry">
<div class="shell">
<div class="form-card" data-anim="up" style="max-width:860px;margin:0 auto">
<div class="center" style="margin-bottom:2.25rem">
<span class="eyebrow">Get started</span>
<h2>Start Your Assessment</h2>
<p class="lead" style="margin:.85rem auto 0;max-width:520px">Fill in your details and our team will send your eligibility result to your registered email.</p>
</div>
<!-- Front-end only: wire the `action`/`method` below to your mail handler or CRM endpoint. -->
<form data-enquiry-form id="assessment-form" action="{{ route('enquiry.store') }}" method="post" novalidate>
@csrf
<input type="hidden" name="form" value="assessment-form"/>
<div class="form-grid">
<div class="field"><label for="assessment-form-name">Name</label><input id="assessment-form-name" name="name" type="text" autocomplete="name" required/><span class="error"></span></div>
<div class="field"><label for="assessment-form-number">Number</label><input id="assessment-form-number" name="number" type="tel" autocomplete="tel" required/><span class="error"></span></div>
<div class="field"><label for="assessment-form-country">Country of Interest</label>
<select id="assessment-form-country" name="country" required>
<option value="">Select a country</option>
<option>Canada</option><option>Australia</option><option>USA</option>
<option>United Kingdom</option><option>New Zealand</option><option>Europe</option>
<option>Other</option>
</select><span class="error"></span></div>
<div class="field"><label for="assessment-form-email">Email</label><input id="assessment-form-email" name="email" type="email" autocomplete="email" required/><span class="error"></span></div>
<div class="field field--full"><label for="assessment-form-message">Message</label><textarea id="assessment-form-message" name="message" rows="4"></textarea><span class="error"></span></div>
</div>
<button class="btn btn--primary btn--lg btn--block" type="submit" style="margin-top:1.75rem">Get My Result <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14m-7-7 7 7-7 7"/></svg></button>
<p class="form-status" role="status" aria-live="polite"></p>
</form>
</div>
</div>
</section>
@endsection
