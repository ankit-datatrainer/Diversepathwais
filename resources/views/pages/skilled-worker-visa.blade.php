@extends('layouts.site')

@section('content')
<section class="page-hero" style="background-image: url('{{ asset('assets/img/banners/banner-skilled-worker.jpg') }}');">
<div class="shell">
<nav class="breadcrumb" aria-label="Breadcrumb"><a href="{{ url('/') }}">Home</a><span>/</span>Skilled Worker Visa</nav>
<div class="page-hero__content">
<span class="page-hero__eyebrow" data-anim="up">SKILLED MIGRATION</span>
<h1 class="page-hero__title" data-anim="up">SKILLED WORKER VISA</h1>
<p class="page-hero__lead" data-anim="up" style="--d:110ms">Move abroad with confidence. Skilled migration visas are designed for qualified professionals, offering better career opportunities and a brighter future.</p>
</div>
</div>
</section><section class="section">
<div class="shell">
<div class="layout">
<div class="prose" data-anim="up"><p>Skilled Migration Visas are designed for qualified professionals and individuals with the education, experience, and expertise needed to contribute to a country&rsquo;s economy. This visa pathway provides skilled people with the opportunity to build their careers abroad while securing long-term settlement options.</p><p>Applicants are generally assessed through a points-based system that takes into account key factors such as age, occupation, educational background, work experience, and English language proficiency. Meeting these requirements is essential to qualify for a permanent residency program under skilled migration.</p><p>In some cases, applicants can also strengthen their profile by providing proof of close relatives who are citizens or permanent residents of the destination country. Additionally, mandatory medical examinations are required before final visa approval.</p><p>Successful candidates are usually granted permanent residency for a specified number of years, after which they may become eligible for citizenship. Skilled migration not only opens doors to career opportunities but also provides a pathway to secure a stable and prosperous future abroad.</p></div>
<aside class="sidebar" data-anim-group="90">
<div class="side-card" data-anim="left"><h3>Visa Categories</h3><ul><li><a href="{{ url('skilled-worker-visa') }}" class="is-active">Skilled Worker Visa</a></li><li><a href="{{ url('student-visa') }}">Student / Study Visa</a></li><li><a href="{{ url('family-visa') }}">Family Visa</a></li><li><a href="{{ url('visitor-visa') }}">Visitor Visa</a></li><li><a href="{{ url('work-permit') }}">Work Permit</a></li></ul></div>
<div class="side-card" data-anim="left"><h3>Our Services</h3><ul><li><a href="{{ url('consultation') }}">Consultation</a></li><li><a href="{{ url('eligibility-assessment') }}">Eligibility Assessment</a></li><li><a href="{{ url('application-processing') }}">Application Processing</a></li></ul></div>
<div class="side-card side-card--cta" data-anim="left">
<h3>Planning to Move Abroad?</h3>
<p>Talk to a licensed consultant and find out which pathway fits your profile.</p>
<a class="btn btn--gold btn--block" href="{{ url('contact-us') }}">Contact Us <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14m-7-7 7 7-7 7"/></svg></a>
</div>
</aside>
</div>
</div>
</section>
@endsection
