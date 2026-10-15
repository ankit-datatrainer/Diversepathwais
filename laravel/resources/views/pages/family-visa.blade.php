@extends('layouts.site')

@section('content')
<section class="page-hero" style="background-image: url('{{ asset('assets/img/banners/banner-family-visa.jpg') }}');">
<div class="shell">
<nav class="breadcrumb" aria-label="Breadcrumb"><a href="{{ url('/') }}">Home</a><span>/</span>Family Visa</nav>
<div class="page-hero__content">
<span class="page-hero__eyebrow" data-anim="up">FAMILY REUNIFICATION</span>
<h1 class="page-hero__title" data-anim="up">FAMILY VISA</h1>
<p class="page-hero__lead" data-anim="up" style="--d:110ms">Reunite with your loved ones abroad with smooth documentation and stress-free approvals.</p>
</div>
</div>
</section><section class="section">
<div class="shell">
<div class="layout">
<div class="prose" data-anim="up"><p>Moving to another country with your family is no longer a challenge. At Diverse Pathwais PVT LTD., we provide hassle-free family visa services that make it easier for you to reunite with your loved ones abroad. Many countries offer family visa programs designed to ensure that families can live together without unnecessary complications.</p><p>A Family Visa allows eligible family members to live, work, and migrate together. If one or more members of your family are already settled in a country, the rest of the family may be able to join them through a family reunification pathway. At Diverse Pathwais PVT LTD., our services are designed to honor the importance of keeping families together while complying with all immigration laws.</p><p>Another option for family reunification is spousal immigration, where one spouse migrates to join the other who is already a resident or citizen of the destination country. In most cases, a sponsorship letter from your relative or spouse&mdash;who holds permanent residency or citizenship&mdash;is required along with other supporting documents to initiate the process.</p><p>At Diverse Pathwais PVT LTD., we help you navigate every step of the application, ensuring smooth documentation, accurate filing, and a stress-free experience. Our goal is to bring families closer by making international relocation simple and efficient.</p></div>
<aside class="sidebar" data-anim-group="90">
<div class="side-card" data-anim="left"><h3>Visa Categories</h3><ul><li><a href="{{ url('skilled-worker-visa') }}">Skilled Worker Visa</a></li><li><a href="{{ url('student-visa') }}">Student / Study Visa</a></li><li><a href="{{ url('family-visa') }}" class="is-active">Family Visa</a></li><li><a href="{{ url('visitor-visa') }}">Visitor Visa</a></li><li><a href="{{ url('work-permit') }}">Work Permit</a></li></ul></div>
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
