@extends('layouts.site')

@section('content')
<section class="page-hero" style="background-image: url('{{ asset('assets/img/banners/banner-visitor-visa.jpg') }}');">
<div class="shell">
<nav class="breadcrumb" aria-label="Breadcrumb"><a href="{{ url('/') }}">Home</a><span>/</span>Visitor Visa</nav>
<div class="page-hero__content">
<span class="page-hero__eyebrow" data-anim="up">GLOBAL TRAVEL</span>
<h1 class="page-hero__title" data-anim="up">VISITOR VISA</h1>
<p class="page-hero__lead" data-anim="up" style="--d:110ms">Explore the world with ease. Our visitor visa services make traveling abroad simple, quick, and stress-free.</p>
</div>
</div>
</section><section class="section">
<div class="shell">
<div class="layout">
<div class="prose" data-anim="up"><p>Traveling abroad is always exciting, whether for leisure, business, or meeting loved ones. To make this possible, you need a Visitor Visa or Temporary Resident Permit (TRP), depending on your destination. While the application process can sometimes feel lengthy or complicated, Diverse Pathwais PVT LTD. ensures a smooth and stress-free experience.</p><p>Many countries require applicants to go through interviews and lengthy documentation to prove the purpose of their visit and guarantee their return within the permitted time. At Diverse Pathwais PVT LTD., we simplify this process by guiding you through every step and ensuring your application meets all requirements.</p><p>In most cases, applicants need to undergo a medical examination to confirm they are not suffering from any serious illness that could pose a risk to public health. Once completed, the visitor visa process is usually quicker compared to other visa categories.</p><p>Depending on your travel plans, you can apply for a single-entry visa, multiple-entry visa, or transit visa. Our trained consultants prepare a foolproof application for you, minimizing the chances of refusal and making international travel simpler than ever.</p><p>With Diverse Pathwais PVT LTD., your dream of exploring the world becomes hassle-free and enjoyable.</p></div>
<aside class="sidebar" data-anim-group="90">
<div class="side-card" data-anim="left"><h3>Visa Categories</h3><ul><li><a href="{{ url('skilled-worker-visa') }}">Skilled Worker Visa</a></li><li><a href="{{ url('student-visa') }}">Student / Study Visa</a></li><li><a href="{{ url('family-visa') }}">Family Visa</a></li><li><a href="{{ url('visitor-visa') }}" class="is-active">Visitor Visa</a></li><li><a href="{{ url('work-permit') }}">Work Permit</a></li></ul></div>
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
