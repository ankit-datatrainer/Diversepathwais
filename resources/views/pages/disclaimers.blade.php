@extends('layouts.site')

@section('content')
<section class="page-hero" style="background-image: url('{{ asset('assets/img/banners/banner-about.jpg') }}');">
<div class="shell">
<nav class="breadcrumb" aria-label="Breadcrumb"><a href="{{ url('/') }}">Home</a><span>/</span>Disclaimers</nav>
<div class="page-hero__content">
<span class="page-hero__eyebrow" data-anim="up">LEGAL NOTICE</span>
<h1 class="page-hero__title" data-anim="up">DISCLAIMERS</h1>
<p class="page-hero__lead" data-anim="up" style="--d:110ms">Important regulatory disclosures regarding authorized immigration representation and website content.</p>
</div>
</div>
</section><section class="section">
<div class="shell">
<div class="layout">
<div class="prose" data-anim="up"><p>Every reasonable effort is made to ensure that the information provided on this site is accurate, no guarantees for the accuracy of information are made. Diverse Pathwais PVT LTD. website and material relating to information &amp; immigration policies, is provided &ldquo;as is&rdquo;. Information on the websites is subject to change without prior notice. Diverse Pathwais PVT LTD. is not liable for any inaccuracy or incomplete information and you may call our office for any other clarification or additional information.</p><p>You shall be assessed solely on the basis of information provided by you through our website. You shall ensure that all the information provided is true &amp; complete and same shall be binding on you.</p><p>For any suggestion or feedback on the site, please contact any of our branch offices or you may write to <a href="mailto:diversepathwise@gmail.com">diversepathwise@gmail.com</a></p></div>
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
