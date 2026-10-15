@extends('layouts.site')

@section('content')
<section class="page-hero" style="background-image: url('{{ asset('assets/img/banners/banner-work-permit.jpg') }}');">
<div class="shell">
<nav class="breadcrumb" aria-label="Breadcrumb"><a href="{{ url('/') }}">Home</a><span>/</span>Work Permit</nav>
<div class="page-hero__content">
<span class="page-hero__eyebrow" data-anim="up">CAREER MOBILITY</span>
<h1 class="page-hero__title" data-anim="up">WORK PERMIT</h1>
<p class="page-hero__lead" data-anim="up" style="--d:110ms">Build your career abroad with our expert work permit assistance.</p>
</div>
</div>
</section><section class="section">
<div class="shell">
<div class="layout">
<div class="prose" data-anim="up"><h2>Applicable Outside India Only</h2><p>To be eligible for a working visa in your destination country, you will typically need to meet one of the following criteria:</p><ul><li><strong>Right to Work</strong> : You may qualify if you have the right to work based on ancestry, nationality, or through a partner who is a citizen or resident of that country.</li><li><strong>Valid Work Permit or Visa</strong> : A work permit or visa that allows you to work is usually arranged by your employer on your behalf.</li><li><strong>Skills-Based Visa</strong> : If you possess relevant skills, qualifications, and work experience, you may be eligible for a temporary or permanent working visa that enables you to work legally.</li></ul><p>At Diverse Pathways , we guide you through the visa process to ensure you meet the necessary requirements for working abroad.</p></div>
<aside class="sidebar" data-anim-group="90">
<div class="side-card" data-anim="left"><h3>Visa Categories</h3><ul><li><a href="{{ url('skilled-worker-visa') }}">Skilled Worker Visa</a></li><li><a href="{{ url('student-visa') }}">Student / Study Visa</a></li><li><a href="{{ url('family-visa') }}">Family Visa</a></li><li><a href="{{ url('visitor-visa') }}">Visitor Visa</a></li><li><a href="{{ url('work-permit') }}" class="is-active">Work Permit</a></li></ul></div>
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
