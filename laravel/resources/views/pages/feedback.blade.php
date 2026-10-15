@extends('layouts.site')

@section('content')
<section class="page-hero" style="background-image: url('{{ asset('assets/img/banners/banner-about.jpg') }}');">
<div class="shell">
<nav class="breadcrumb" aria-label="Breadcrumb"><a href="{{ url('/') }}">Home</a><span>/</span>Feedback</nav>
<div class="page-hero__content">
<span class="page-hero__eyebrow" data-anim="up">SHARE YOUR THOUGHTS</span>
<h1 class="page-hero__title" data-anim="up">CLIENT FEEDBACK</h1>
<p class="page-hero__lead" data-anim="up" style="--d:110ms">Your feedback helps us refine our guidance, streamline documentation, and elevate every client journey.</p>
</div>
</div>
</section><section class="section section--tight">
<div class="shell"><div class="prose" data-anim="up" style="margin:0 auto">
<p>We value your feedback and strive to improve our services continuously. To assist you better, we&rsquo;ve created a simple form that captures key details about your query, ensuring quick and efficient support.</p>
</div></div>
</section><section class="section form-band" id="enquiry">
<div class="shell">
<div class="form-card" data-anim="up" style="max-width:860px;margin:0 auto">
<div class="center" style="margin-bottom:2.25rem">
<span class="eyebrow">Get started</span>
<h2>Share Your Feedback</h2>
<p class="lead" style="margin:.85rem auto 0;max-width:520px">Tell us about your experience and our team will follow up with you.</p>
</div>
<!-- Front-end only: wire the `action`/`method` below to your mail handler or CRM endpoint. -->
<form data-enquiry-form id="feedback-form" action="{{ route('enquiry.store') }}" method="post" novalidate>
@csrf
<input type="hidden" name="form" value="feedback-form"/>
<div class="form-grid">
<div class="field"><label for="feedback-form-name">Name</label><input id="feedback-form-name" name="name" type="text" autocomplete="name" required/><span class="error"></span></div>
<div class="field"><label for="feedback-form-number">Number</label><input id="feedback-form-number" name="number" type="tel" autocomplete="tel" required/><span class="error"></span></div>
<div class="field"><label for="feedback-form-country">Country of Interest</label>
<select id="feedback-form-country" name="country" required>
<option value="">Select a country</option>
<option>Canada</option><option>Australia</option><option>USA</option>
<option>United Kingdom</option><option>New Zealand</option><option>Europe</option>
<option>Other</option>
</select><span class="error"></span></div>
<div class="field"><label for="feedback-form-email">Email</label><input id="feedback-form-email" name="email" type="email" autocomplete="email" required/><span class="error"></span></div>
<div class="field field--full"><label for="feedback-form-message">Message</label><textarea id="feedback-form-message" name="message" rows="4"></textarea><span class="error"></span></div>
</div>
<button class="btn btn--primary btn--lg btn--block" type="submit" style="margin-top:1.75rem">Submit Feedback <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14m-7-7 7 7-7 7"/></svg></button>
<p class="form-status" role="status" aria-live="polite"></p>
</form>
</div>
</div>
</section>
@endsection
