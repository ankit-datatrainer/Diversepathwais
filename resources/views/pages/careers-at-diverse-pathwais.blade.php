@extends('layouts.site')

@section('content')
<section class="page-hero" style="background-image: url('{{ asset('assets/img/banners/banner-about.jpg') }}');">
<div class="shell">
<nav class="breadcrumb" aria-label="Breadcrumb"><a href="{{ url('/') }}">Home</a><span>/</span>Careers at Diverse Pathwais</nav>
<div class="page-hero__content">
<span class="page-hero__eyebrow" data-anim="up">JOIN OUR TEAM</span>
<h1 class="page-hero__title" data-anim="up">CAREERS AT DIVERSE PATHWAIS</h1>
<p class="page-hero__lead" data-anim="up" style="--d:110ms">We develop professionals into leaders who create value and believe in shaping the future.</p>
</div>
</div>
</section><section class="section">
<div class="shell">
<div class="layout">
<div class="prose" data-anim="up"><h2>Can You Do That?</h2><p>At Diverse Pathwais PVT LTD., we believe relationships are the foundation of success. In today&rsquo;s corporate world, gaining new clients is important, but maintaining and retaining them is equally vital. Building trust, understanding needs, and creating meaningful connections are what truly drive growth. If you are someone who understands the power of human relationships and values long-term connections, we are looking for you.</p><h2>What Is This All About?</h2><p>At Diverse Pathwais PVT LTD., we develop professionals into leaders who create value and believe in shaping the future. Integrity, creativity, passion, and a &ldquo;can-do&rdquo; attitude are qualities we value most. We encourage innovation, learning, and goal-setting while empowering our people to take initiatives and succeed.</p><p>We are looking for dynamic, innovative, and motivated individuals who can build strong relationships with clients and turn prospects into long-term success stories. If you can engage, understand, and inspire others, you are the right fit for us.</p><h2>Why Join Us?</h2><p>Diverse Pathwais PVT LTD. is a trusted name in visa and immigration services, with a growing global presence and a professional team dedicated to excellence. Our work environment is open, supportive, and growth-oriented, offering the perfect balance of challenge and opportunity.</p><h2>What We Offer</h2><ul><li>A positive and professional work environment that supports growth</li><li>Competitive remuneration and performance-based rewards</li><li>Opportunities for learning, development, and global exposure</li><li>Career pathways that enable both personal and professional success</li></ul><h2>Are You Inspired?</h2><p>If this excites you and you feel you are the person we are looking for, we would love to hear from you. Write to us at <a href="mailto:diversepathwise@gmail.com">diversepathwise@gmail.com</a>.</p></div>
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
