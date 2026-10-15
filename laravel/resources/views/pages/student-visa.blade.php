@extends('layouts.site')

@section('content')
<section class="page-hero" style="background-image: url('{{ asset('assets/img/banners/banner-student-visa.jpg') }}');">
<div class="shell">
<nav class="breadcrumb" aria-label="Breadcrumb"><a href="{{ url('/') }}">Home</a><span>/</span>Student / Study Visa</nav>
<div class="page-hero__content">
<span class="page-hero__eyebrow" data-anim="up">GLOBAL EDUCATION</span>
<h1 class="page-hero__title" data-anim="up">STUDENT / STUDY VISA</h1>
<p class="page-hero__lead" data-anim="up" style="--d:110ms">Study at top universities worldwide. We guide students through admission requirements, applications, and approvals.</p>
</div>
</div>
</section><section class="section">
<div class="shell">
<div class="layout">
<div class="prose" data-anim="up"><p>With growing global integration, the education sector continues to attract millions of students worldwide. Studying abroad is no longer just a trend&mdash;it is a pathway to educational excellence, international exposure, better career opportunities, and high earning potential. However, choosing the right course, institution, and country can often feel overwhelming in today&rsquo;s fast-changing world.</p><p>At Diverse Pathwais PVT LTD., we provide expert guidance to students who aspire to study overseas and build a successful career. Our student visa services are designed to make the entire process hassle-free, from career counseling and university selection to visa applications and settlement guidance.</p><p>Through our partnerships with leading universities and colleges across the globe, we help students explore a wide range of educational opportunities in countries such as Australia, Canada, USA, UK, Germany, Ireland, New Zealand, Switzerland, Poland, Netherlands, Denmark, and Malaysia.</p><p>We support students at every stage of their journey&mdash;helping them choose the right course, prepare their applications, complete admission requirements, and smoothly transition into their new academic life abroad. Beyond education, we also guide students on potential pathways to work and settle in their chosen destination after graduation.</p><p>Our mission at Diverse Pathwais PVT LTD. is to be a one-stop education and visa consultancy, ensuring that each student finds the best match for their academic goals, financial situation, lifestyle, and career aspirations.</p></div>
<aside class="sidebar" data-anim-group="90">
<div class="side-card" data-anim="left"><h3>Visa Categories</h3><ul><li><a href="{{ url('skilled-worker-visa') }}">Skilled Worker Visa</a></li><li><a href="{{ url('student-visa') }}" class="is-active">Student / Study Visa</a></li><li><a href="{{ url('family-visa') }}">Family Visa</a></li><li><a href="{{ url('visitor-visa') }}">Visitor Visa</a></li><li><a href="{{ url('work-permit') }}">Work Permit</a></li></ul></div>
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
