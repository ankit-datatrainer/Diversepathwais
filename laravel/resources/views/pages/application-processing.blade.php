@extends('layouts.site')

@section('content')
<section class="page-hero" style="background-image: url('{{ asset('assets/img/banners/banner-application-processing.jpg') }}');">
<div class="shell">
<nav class="breadcrumb" aria-label="Breadcrumb"><a href="{{ url('/') }}">Home</a><span>/</span>Application Processing</nav>
<div class="page-hero__content">
<span class="page-hero__eyebrow" data-anim="up">DOCUMENTATION & FILING</span>
<h1 class="page-hero__title" data-anim="up">APPLICATION PROCESSING</h1>
<p class="page-hero__lead" data-anim="up" style="--d:110ms">Professionals assist in preparing, verifying, and submitting immigration documents efficiently.</p>
</div>
</div>
</section><section class="section">
<div class="shell">
<div class="layout">
<div class="prose" data-anim="up"><h2>Immigrant Visa Application Support</h2><p>At Diverse Pathwais PVT LTD ., we help you assess your eligibility for Canadian immigration and determine the right immigration category based on your profile. Our team ensures that your application is accurate, complete, and professionally managed from start to finish.</p><p>Once you choose our services, we will:</p><ul><li>Prepare, review, and submit your application with precision</li><li>Communicate directly with the Immigration Visa Office on your behalf</li><li>Guide and prepare you for interviews (if required)</li><li>Manage all correspondence with the Processing Centre until your visa is issued</li><li>Address your concerns and provide timely solutions</li></ul><p>We also assist with challenges that may arise during the process, including:</p><ul><li>Proving work experience and English language ability</li><li>Resolving issues related to medical or criminal inadmissibility</li><li>Handling application refusals or long delays</li></ul><p>At Diverse Pathwais PVT LTD ., our immigration experts are always available to answer your questions, provide guidance, and ensure a smooth visa application experience.</p></div>
<aside class="sidebar" data-anim-group="90">
<div class="side-card" data-anim="left"><h3>Visa Categories</h3><ul><li><a href="{{ url('skilled-worker-visa') }}">Skilled Worker Visa</a></li><li><a href="{{ url('student-visa') }}">Student / Study Visa</a></li><li><a href="{{ url('family-visa') }}">Family Visa</a></li><li><a href="{{ url('visitor-visa') }}">Visitor Visa</a></li><li><a href="{{ url('work-permit') }}">Work Permit</a></li></ul></div>
<div class="side-card" data-anim="left"><h3>Our Services</h3><ul><li><a href="{{ url('consultation') }}">Consultation</a></li><li><a href="{{ url('eligibility-assessment') }}">Eligibility Assessment</a></li><li><a href="{{ url('application-processing') }}" class="is-active">Application Processing</a></li></ul></div>
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
