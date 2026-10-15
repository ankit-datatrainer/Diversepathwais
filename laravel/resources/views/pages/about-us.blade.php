@extends('layouts.site')

@section('content')
<section class="page-hero" style="background-image: url('{{ asset('assets/img/banners/banner-about.jpg') }}');">
<div class="shell">
<nav class="breadcrumb" aria-label="Breadcrumb"><a href="{{ url('/') }}">Home</a><span>/</span>About Us</nav>
<div class="page-hero__content">
<span class="page-hero__eyebrow" data-anim="up">WHO WE ARE</span>
<h1 class="page-hero__title" data-anim="up">ABOUT US</h1>
<p class="page-hero__lead" data-anim="up" style="--d:110ms">A leading global immigration and visa consultancy, helping individuals and families achieve their dreams of studying, working and settling abroad.</p>
</div>
</div>
</section><section class="section">
<div class="shell">
<div class="layout">
<div class="prose" data-anim="up"><p>Diverse Pathwais PVT LTD. is a leading global immigration and visa consultancy, committed to helping individuals and families achieve their dreams of studying, working, and settling abroad. With years of experience in the immigration industry, we specialize in business visas, skilled worker visas, study visas, and investment-based immigration programs.</p><p>Over the years, Diverse Pathwais PVT LTD. has successfully assisted many of clients in securing opportunities across top destinations, including Canada, the United States, Australia, New Zealand, the United Kingdom, and leading European countries such as Germany, Portugal, Spain, Greece, Malta, Cyprus, and many more.</p><p>With a growing presence through our dedicated consultants and international associates, Diverse Pathwais PVT LTD. ensures a personalized and transparent immigration process. From initial consultation to visa approval, our team provides end-to-end guidance tailored to your profile and goals.</p><p>Backed by credibility, expertise, and a customer-first approach, Diverse Pathwais PVT LTD. stands as a trusted choice for immigration, citizenship, and second passport solutions. Our mission is simple &mdash; to make the journey abroad smoother, faster, and stress-free for every client.</p></div>
<aside class="sidebar" data-anim-group="90">
<div class="side-card" data-anim="left"><h3>Visa Categories</h3><ul><li><a href="{{ url('skilled-worker-visa') }}">Skilled Worker Visa</a></li><li><a href="{{ url('student-visa') }}">Student / Study Visa</a></li><li><a href="{{ url('family-visa') }}">Family Visa</a></li><li><a href="{{ url('visitor-visa') }}">Visitor Visa</a></li><li><a href="{{ url('work-permit') }}">Work Permit</a></li></ul></div>
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
