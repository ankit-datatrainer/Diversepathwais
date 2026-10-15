@extends('layouts.site')

@section('content')
<section class="page-hero" style="background-image: url('{{ asset('assets/img/banners/banner-contact-us.jpg') }}');">
<div class="shell">
<nav class="breadcrumb" aria-label="Breadcrumb"><a href="{{ url('/') }}">Home</a><span>/</span>Contact Us</nav>
<div class="page-hero__content">
<span class="page-hero__eyebrow" data-anim="up">GET IN TOUCH</span>
<h1 class="page-hero__title" data-anim="up">CONTACT US</h1>
<p class="page-hero__lead" data-anim="up" style="--d:110ms">Our licensed consultants are available to answer your questions about visas, work permits and settlement abroad.</p>
</div>
</div>
</section>
<section class="section">
<div class="shell">
<div class="contact-grid" data-anim-group="100">
<div class="contact-card" data-anim="up"><div class="contact-card__ic"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.8 19.8 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.12 4.18 2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92z"/></svg></div><h3>Call Us</h3><ul><li><a href="tel:+919773916555">+91 9773916555</a></li><li><a href="tel:+919319090505">+91 9319090505</a></li></ul></div>
<div class="contact-card" data-anim="up"><div class="contact-card__ic"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m2 7 10 6 10-6"/></svg></div><h3>Email Us</h3><ul><li><a href="mailto:diversepathwise@gmail.com">diversepathwise@gmail.com</a></li></ul></div>
<div class="contact-card" data-anim="up"><div class="contact-card__ic"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg></div><h3>Visit Us</h3><div class="contact-card__offices"><div class="contact-card__office"><strong class="contact-card__office-title">Registered Office</strong><p>Ground floor No. 112, World Trade Centre, Near The Lalit Hotel, Connaught Place, New Delhi, Delhi-110001</p></div><div class="contact-card__office"><strong class="contact-card__office-title">Other branches</strong><p>Fourth Floor No. 407, World Trade Centre, Near The Lalit Hotel, Connaught Place, New Delhi, Delhi-110001</p></div></div></div>
<div class="contact-card" data-anim="up"><div class="contact-card__ic"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg></div><h3>Follow Us</h3><div class="contact-card__social"><a class="contact-card__social-btn contact-card__social-btn--fb" href="https://www.facebook.com/profile.php?id=61591898733892" target="_blank" rel="noopener" aria-label="Facebook"><svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M13.5 22v-8h2.7l.4-3.1h-3.1V8.9c0-.9.25-1.5 1.55-1.5H16.7V4.62A21 21 0 0 0 14.28 4.5c-2.4 0-4.05 1.47-4.05 4.16v2.24H7.5V14h2.73v8z"/></svg></a><a class="contact-card__social-btn contact-card__social-btn--ig" href="https://www.instagram.com/diversepathwaispvtltd/?hl=en" target="_blank" rel="noopener" aria-label="Instagram"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.2" cy="6.8" r="1.2" fill="currentColor" stroke="none"/></svg></a><a class="contact-card__social-btn contact-card__social-btn--li" href="#" aria-label="LinkedIn" rel="noopener"><svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg></a><a class="contact-card__social-btn contact-card__social-btn--yt" href="#" aria-label="Youtube" rel="noopener"><svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M21.6 7.2a2.5 2.5 0 0 0-1.77-1.77C18.25 5 12 5 12 5s-6.25 0-7.83.43A2.5 2.5 0 0 0 2.4 7.2 26 26 0 0 0 2 12a26 26 0 0 0 .4 4.8 2.5 2.5 0 0 0 1.77 1.77C5.75 19 12 19 12 19s6.25 0 7.83-.43a2.5 2.5 0 0 0 1.77-1.77A26 26 0 0 0 22 12a26 26 0 0 0-.4-4.8zM10 15.02V8.98L15.2 12z"/></svg></a></div></div>
</div>
</div>
</section>
<section class="section section--offices" style="padding-top: 0;">
<div class="shell">
<div class="center" style="margin-bottom: 2.5rem;" data-anim="up">
<span class="eyebrow">OUR LOCATIONS</span>
<h2>Our Offices in Connaught Place</h2>
<p class="lead" style="margin: .75rem auto 0; max-width: 580px;">Visit our registered headquarters or branch office for personalized one-on-one immigration consultations.</p>
</div>
<div class="offices-grid" data-anim-group="100">
<div class="office-card office-card--primary" data-anim="up">
<div class="office-card__badge"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg> Registered Office</div>
<div class="office-card__header">
<div class="office-card__icon">
<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="4" y="2" width="16" height="20" rx="2"/><path d="M9 22v-4h6v4"/><path d="M8 6h.01M16 6h.01M12 6h.01M8 10h.01M16 10h.01M12 10h.01M8 14h.01M16 14h.01M12 14h.01"/></svg>
</div>
<div>
<h3 class="office-card__title">Registered Office</h3>
<span class="office-card__subtitle">Ground Floor &middot; World Trade Centre</span>
</div>
</div>
<div class="office-card__body">
<div class="office-card__item">
<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
<div>
<strong>Office Address:</strong>
<p>Ground floor No. 112, World Trade Centre, Near The Lalit Hotel, Connaught Place, New Delhi, Delhi-110001</p>
</div>
</div>
<div class="office-card__item">
<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
<div>
<strong>Working Hours:</strong>
<p>Mon &ndash; Sat: 9:30 AM &ndash; 6:30 PM <span class="office-tag">Sunday Closed</span></p>
</div>
</div>
<div class="office-card__item">
<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.8 19.8 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.12 4.18 2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
<div>
<strong>Direct Contact:</strong>
<p><a href="tel:+919773916555">+91 9773916555</a></p>
</div>
</div>
</div>
<div class="office-card__actions">
<a class="btn btn--primary btn--sm" href="https://maps.google.com/?q=Ground+Floor+No.+112+World+Trade+Centre+Near+The+Lalit+Hotel+Connaught+Place+New+Delhi+Delhi-110001" target="_blank" rel="noopener">
<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><polygon points="3 11 22 2 13 21 11 13 3 11"/></svg> Get Directions
</a>
<a class="btn btn--outline btn--sm" href="tel:+919773916555">Call Office</a>
</div>
</div>

<div class="office-card" data-anim="up">
<div class="office-card__badge office-card__badge--secondary"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18M5 21V7l8-4v18M19 21V11l-6-4"/></svg> Branch Office</div>
<div class="office-card__header">
<div class="office-card__icon">
<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
</div>
<div>
<h3 class="office-card__title">Other branches</h3>
<span class="office-card__subtitle">Fourth Floor &middot; World Trade Centre</span>
</div>
</div>
<div class="office-card__body">
<div class="office-card__item">
<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
<div>
<strong>Office Address:</strong>
<p>Fourth Floor No. 407, World Trade Centre, Near The Lalit Hotel, Connaught Place, New Delhi, Delhi-110001</p>
</div>
</div>
<div class="office-card__item">
<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
<div>
<strong>Working Hours:</strong>
<p>Mon &ndash; Sat: 9:30 AM &ndash; 6:30 PM <span class="office-tag">Sunday Closed</span></p>
</div>
</div>
<div class="office-card__item">
<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.8 19.8 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.12 4.18 2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
<div>
<strong>Direct Contact:</strong>
<p><a href="tel:+919319090505">+91 9319090505</a></p>
</div>
</div>
</div>
<div class="office-card__actions">
<a class="btn btn--primary btn--sm" href="https://maps.google.com/?q=Fourth+Floor+No.+407+World+Trade+Centre+Near+The+Lalit+Hotel+Connaught+Place+New+Delhi+Delhi-110001" target="_blank" rel="noopener">
<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><polygon points="3 11 22 2 13 21 11 13 3 11"/></svg> Get Directions
</a>
<a class="btn btn--outline btn--sm" href="tel:+919319090505">Call Office</a>
</div>
</div>
</div>
</div>
</section>
<section class="section form-band" id="enquiry">
<div class="shell">
<div class="form-card" data-anim="up" style="max-width:860px;margin:0 auto">
<div class="center" style="margin-bottom:2.25rem">
<span class="eyebrow">Get started</span>
<h2>Planning to Move Abroad?</h2>
<p class="lead" style="margin:.85rem auto 0;max-width:520px">Share a few details and one of our consultants will get back to you.</p>
</div>
<!-- Front-end only: wire the `action`/`method` below to your mail handler or CRM endpoint. -->
<form data-enquiry-form id="contact-form" action="{{ route('enquiry.store') }}" method="post" novalidate>
@csrf
<input type="hidden" name="form" value="contact-form"/>
<div class="form-grid">
<div class="field"><label for="contact-form-name">Name</label><input id="contact-form-name" name="name" type="text" autocomplete="name" required/><span class="error"></span></div>
<div class="field"><label for="contact-form-number">Number</label><input id="contact-form-number" name="number" type="tel" autocomplete="tel" required/><span class="error"></span></div>
<div class="field"><label for="contact-form-country">Country of Interest</label>
<select id="contact-form-country" name="country" required>
<option value="">Select a country</option>
<option>Canada</option><option>Australia</option><option>USA</option>
<option>United Kingdom</option><option>New Zealand</option><option>Europe</option>
<option>Other</option>
</select><span class="error"></span></div>
<div class="field"><label for="contact-form-email">Email</label><input id="contact-form-email" name="email" type="email" autocomplete="email" required/><span class="error"></span></div>
<div class="field field--full"><label for="contact-form-message">Message</label><textarea id="contact-form-message" name="message" rows="4"></textarea><span class="error"></span></div>
</div>
<button class="btn btn--primary btn--lg btn--block" type="submit" style="margin-top:1.75rem">Send <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14m-7-7 7 7-7 7"/></svg></button>
<p class="form-status" role="status" aria-live="polite"></p>
</form>
</div>
</div>
</section>
@endsection
