@extends('layouts.site')

@section('content')
<section class="page-hero" style="background-image: url('{{ asset('assets/img/banners/banner-consultation.jpg') }}');">
<div class="shell">
<nav class="breadcrumb" aria-label="Breadcrumb"><a href="{{ url('/') }}">Home</a><span>/</span>Consultation</nav>
<div class="page-hero__content">
<span class="page-hero__eyebrow" data-anim="up">LEGAL ADVISORY</span>
<h1 class="page-hero__title" data-anim="up">CONSULTATION</h1>
<p class="page-hero__lead" data-anim="up" style="--d:110ms">Expert consultants provide valuable guidance and visa knowledge for a smooth immigration process.</p>
</div>
</div>
</section><section class="section">
<div class="shell">
<div class="layout">
<div class="prose" data-anim="up"><p>At Diverse Pathwais PVT LTD., our consultation services give you the opportunity to connect with experienced immigration consultants who have in-depth knowledge of visa application processes across multiple countries. Whether over a phone call or in person, our experts provide detailed guidance tailored to your individual situation.</p><p>Every applicant&rsquo;s journey is unique, and discussing your case with our consultants helps you gain a clear understanding of the requirements, procedures, and next steps. By addressing your questions and concerns directly, we increase the chances of a smooth and successful visa application.</p><p>In some cases, specific issues may require extra time and attention. That&rsquo;s why we recommend getting in touch with our consultants early, so potential challenges can be identified and resolved before they delay your application.</p><p>Many clients choose to register with Diverse Pathwais PVT LTD. during their visa process because applications can be complex and time-consuming. Our experts help you understand each stage clearly, reducing errors, preventing re-submissions, and ensuring that your application remains on track. The knowledge and experience shared by our consultants not only saves time but also provides the confidence you need while applying for your visa.</p></div>
<aside class="sidebar" data-anim-group="90">
<div class="side-card" data-anim="left"><h3>Visa Categories</h3><ul><li><a href="{{ url('skilled-worker-visa') }}">Skilled Worker Visa</a></li><li><a href="{{ url('student-visa') }}">Student / Study Visa</a></li><li><a href="{{ url('family-visa') }}">Family Visa</a></li><li><a href="{{ url('visitor-visa') }}">Visitor Visa</a></li><li><a href="{{ url('work-permit') }}">Work Permit</a></li></ul></div>
<div class="side-card" data-anim="left"><h3>Our Services</h3><ul><li><a href="{{ url('consultation') }}" class="is-active">Consultation</a></li><li><a href="{{ url('eligibility-assessment') }}">Eligibility Assessment</a></li><li><a href="{{ url('application-processing') }}">Application Processing</a></li></ul></div>
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
