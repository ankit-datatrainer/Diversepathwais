@extends('layouts.site')

@push('head')
<link rel="preload" as="image" href="{{ asset('assets/img/Diverse-Pathwais.webp') }}" fetchpriority="high"/>
@endpush
@section('content')
<h1 class="sr-only">Diverse Pathwais PVT LTD. &mdash; Visa and Immigration Consultants</h1>
<section class="video-hero" id="hero" aria-label="Diverse Pathwais Global Visa Consultancy">
<video class="video-hero__video" autoplay loop muted playsinline preload="auto" poster="{{ asset('assets/img/hero-video-poster.webp') }}">
<source src="{{ asset('assets/visa_hero_section.mp4') }}" type="video/mp4">
</video>
<div class="video-hero__overlay" aria-hidden="true"></div>
<div class="video-hero__content">
<div class="shell">
<div class="video-hero__inner">
<div class="video-hero__tag" data-anim="up">
<span class="video-hero__tag-dot"></span>
<span>Global Visa &amp; Immigration Experts</span>
</div>
<h1 class="video-hero__title" data-anim="up">
<span class="video-hero__title-line">YOUR FUTURE ABROAD</span>
<span class="video-hero__title-line video-hero__title-line--gradient">DOESN'T START WITH LUCK.</span>
</h1>
<p class="video-hero__subtitle" data-anim="up">
Licensed immigration lawyers, MARA agents &amp; RCICs guiding your journey to Canada, Australia, the UK, USA, New Zealand, and Europe.
</p>
<div class="video-hero__actions" data-anim="up">
<a class="btn btn--gold btn--lg" href="{{ url('contact-us') }}">
<span>Get Free Consultation</span>
<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14m-7-7 7 7-7 7"/></svg>
</a>
<a class="btn btn--glass btn--lg" href="#destinations">
<span>Explore Destinations</span>
<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m19 9-7 7-7-7"/></svg>
</a>
</div>
</div>
</div>
</div>
<div class="hero-chips" aria-hidden="true">
<span class="hero-chip"><b>98%</b> visa approval rate</span>
<span class="hero-chip"><b>50+</b> destinations served</span>
<span class="hero-chip"><b>24h</b> free assessment</span>
</div>
<div class="flight-cue" aria-hidden="true"><i></i><span>Scroll to take off</span></div>
</section>

<section class="section section--tight destinations-section" id="destinations">
<div class="shell">
<div class="section-head" data-anim="up">
<span class="eyebrow">Where we take you</span>
<h2>Top <span class="accent">Destinations</span></h2>
</div>
</div>
<div class="marquee" data-marquee-container>
<div class="marquee__track" data-marquee>
<div class="marquee__item" data-destination="canada">
<div class="marquee__flag-box">
<img class="marquee__flag" src="{{ asset('assets/img/Canada.png') }}" alt="Flag of Canada" width="86" height="54" loading="lazy"/>
</div>
<div class="marquee__info">
<h3>Canada</h3><span>Express Entry &amp; PNP</span>
</div>
<a class="marquee__link" href="{{ url('skilled-worker-visa') }}">Explore <span>&rarr;</span></a>
</div>
<div class="marquee__item" data-destination="australia">
<div class="marquee__flag-box">
<img class="marquee__flag" src="{{ asset('assets/img/Australia.png') }}" alt="Flag of Australia" width="86" height="54" loading="lazy"/>
</div>
<div class="marquee__info">
<h3>Australia</h3><span>Skilled migration</span>
</div>
<a class="marquee__link" href="{{ url('skilled-worker-visa') }}">Explore <span>&rarr;</span></a>
</div>
<div class="marquee__item" data-destination="usa">
<div class="marquee__flag-box">
<img class="marquee__flag" src="{{ asset('assets/img/United-State-America.png') }}" alt="Flag of United States" width="86" height="54" loading="lazy"/>
</div>
<div class="marquee__info">
<h3>USA</h3><span>Study &amp; work visas</span>
</div>
<a class="marquee__link" href="{{ url('student-visa') }}">Explore <span>&rarr;</span></a>
</div>
<div class="marquee__item" data-destination="uk">
<div class="marquee__flag-box">
<img class="marquee__flag" src="{{ asset('assets/img/United-Kingdom.png') }}" alt="Flag of United Kingdom" width="86" height="54" loading="lazy"/>
</div>
<div class="marquee__info">
<h3>United Kingdom</h3><span>Skilled worker routes</span>
</div>
<a class="marquee__link" href="{{ url('skilled-worker-visa') }}">Explore <span>&rarr;</span></a>
</div>
<div class="marquee__item" data-destination="nz">
<div class="marquee__flag-box">
<img class="marquee__flag" src="{{ asset('assets/img/New-Zealand.png') }}" alt="Flag of New Zealand" width="86" height="54" loading="lazy"/>
</div>
<div class="marquee__info">
<h3>New Zealand</h3><span>Residence pathways</span>
</div>
<a class="marquee__link" href="{{ url('family-visa') }}">Explore <span>&rarr;</span></a>
</div>
<div class="marquee__item" data-destination="europe">
<div class="marquee__flag-box">
<img class="marquee__flag" src="{{ asset('assets/img/Europe.png') }}" alt="Flag of Europe (EU)" width="86" height="54" loading="lazy"/>
</div>
<div class="marquee__info">
<h3>Europe</h3><span>Germany, Portugal &amp; more</span>
</div>
<a class="marquee__link" href="{{ url('visitor-visa') }}">Explore <span>&rarr;</span></a>
</div>
<div class="marquee__item" data-destination="germany">
<div class="marquee__flag-box">
<img class="marquee__flag" src="{{ asset('assets/img/Germany.png') }}" alt="Flag of Germany" width="86" height="54" loading="lazy"/>
</div>
<div class="marquee__info">
<h3>Germany</h3><span>Opportunity &amp; Blue Card</span>
</div>
<a class="marquee__link" href="{{ url('work-permit') }}">Explore <span>&rarr;</span></a>
</div>
<div class="marquee__item" data-destination="ireland">
<div class="marquee__flag-box">
<img class="marquee__flag" src="{{ asset('assets/img/Ireland.png') }}" alt="Flag of Ireland" width="86" height="54" loading="lazy"/>
</div>
<div class="marquee__info">
<h3>Ireland</h3><span>Critical Skills Employment</span>
</div>
<a class="marquee__link" href="{{ url('work-permit') }}">Explore <span>&rarr;</span></a>
</div>
</div>
</div>
</section>

<section class="hgal" id="visa-categories" data-hgal aria-label="Visa categories">
<div class="hgal__track">
<div class="hgal__stage">
<div class="hgal__head">
<div class="shell">
<div>
<span class="eyebrow eyebrow--light">What we offer</span>
<h2 style="color:#fff">Visa Categories</h2>
</div>
<p style="color:rgba(255,255,255,.66);max-width:380px;margin:0">Every route abroad has its own rules. Pick the one that matches your goal and we will handle the rest.</p>
</div>
</div>
<div class="hgal__rail"><article class="hgal__card">
<img src="{{ asset('assets/img/category-skilled-worker.webp') }}" alt="Skilled Worker Visa" loading="lazy" width="800" height="1066"/>
<div class="hgal__body">
<span class="hgal__index">01 &mdash; MIGRATION</span>
<h3>Skilled Worker Visa</h3>
<p>Move abroad with confidence. Skilled migration visas are designed for qualified professionals, offering better career opportunities and a brighter future through a secure immigration process.</p>
<a class="link-more" style="color:#fff" href="{{ url('skilled-worker-visa') }}">Read More <span class="arrow"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17 17 7m0 0H8m9 0v9"/></svg></span></a>
</div>
</article><article class="hgal__card">
<img src="{{ asset('assets/img/category-student-visa.webp') }}" alt="Student / Study Visa" loading="lazy" width="800" height="1066"/>
<div class="hgal__body">
<span class="hgal__index">02 &mdash; EDUCATION</span>
<h3>Student / Study Visa</h3>
<p>Study at top universities worldwide. Our education visa services guide students through admission requirements, applications, and approvals, helping them achieve global learning and career success.</p>
<a class="link-more" style="color:#fff" href="{{ url('student-visa') }}">Read More <span class="arrow"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17 17 7m0 0H8m9 0v9"/></svg></span></a>
</div>
</article><article class="hgal__card">
<img src="{{ asset('assets/img/category-family-visa.webp') }}" alt="Family Visa" loading="lazy" width="800" height="1066"/>
<div class="hgal__body">
<span class="hgal__index">03 &mdash; REUNIFICATION</span>
<h3>Family Visa</h3>
<p>Reunite with your loved ones abroad. Our family visa services make relocation easier, ensuring smooth documentation and stress-free approvals for a complete family settlement overseas.</p>
<a class="link-more" style="color:#fff" href="{{ url('family-visa') }}">Read More <span class="arrow"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17 17 7m0 0H8m9 0v9"/></svg></span></a>
</div>
</article><article class="hgal__card">
<img src="{{ asset('assets/img/category-visitor-visa.webp') }}" alt="Visitor Visa" loading="lazy" width="800" height="1066"/>
<div class="hgal__body">
<span class="hgal__index">04 &mdash; TRAVEL</span>
<h3>Visitor Visa</h3>
<p>Explore the world with ease. Our visitor visa services make traveling abroad simple, quick, and stress-free for leisure, business, or special occasions.</p>
<a class="link-more" style="color:#fff" href="{{ url('visitor-visa') }}">Read More <span class="arrow"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17 17 7m0 0H8m9 0v9"/></svg></span></a>
</div>
</article><article class="hgal__card">
<img src="{{ asset('assets/img/category-work-permit.webp') }}" alt="Work Permit" loading="lazy" width="800" height="1066"/>
<div class="hgal__body">
<span class="hgal__index">05 &mdash; EMPLOYMENT</span>
<h3>Work Permit</h3>
<p>Build your career abroad with our expert work permit assistance. We guide you through every requirement, ensuring a smooth and successful application process.</p>
<a class="link-more" style="color:#fff" href="{{ url('work-permit') }}">Read More <span class="arrow"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17 17 7m0 0H8m9 0v9"/></svg></span></a>
</div>
</article></div>
<div class="shell"><div class="hgal__bar"><i></i></div></div>
</div>
</div>
</section>

<section class="section about-section" id="about">
<!-- Ambient Floating Shapes -->
<div class="float-shape float-shape--ring float-spin" style="top:25px;right:6%;width:80px;height:80px;"></div>
<div class="float-shape float-shape--dot float-slow-3" style="top:42%;left:3%;width:14px;height:14px;"></div>
<div class="float-shape float-shape--cross float-slow-2" style="bottom:18%;right:48%;"></div>

<div class="shell" style="position:relative;z-index:2">
<div class="split">
<div class="collage" data-anim="right" style="position:relative">
<!-- Floating Badges over Collage -->
<div class="float-badge float-badge--gold float-slow-1" style="top:22px;left:22px;z-index:10;"><span class="float-badge__icon">✦</span> 98% Visa Approvals</div>
<div class="float-badge float-badge--navy float-slow-2" style="bottom:22px;left:22px;z-index:10;"><span class="float-badge__icon">✈</span> 50+ Global Destinations</div>

<div class="collage__main"><img src="{{ asset('assets/img/about-main-team.webp') }}" alt="Senior immigration consultants reviewing approved visas with clients" loading="lazy" width="1200" height="900"/></div>
<div class="collage__sub float-slow-3"><img src="{{ asset('assets/img/about-sub-consultation.webp') }}" alt="Licensed immigration consultant approving client visas" loading="lazy" width="768" height="432"/></div>
</div>
<div class="about-content" data-anim="left">
<span class="eyebrow">About Us</span>
<h2 class="about-title">A Trusted Partner For<br>Your Journey Abroad</h2>
<p class="lead" style="margin-top:1rem">Diverse Pathwais PVT LTD. is a leading global immigration and visa consultancy, committed to helping individuals and families achieve their dreams of studying, working, and settling abroad.</p>
<ul class="checklist">
<li><i><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m20 6-11 11-5-5"/></svg></i><span>Business visas, skilled worker visas, study visas and investment-based immigration programs.</span></li>
<li><i><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m20 6-11 11-5-5"/></svg></i><span>Opportunities across Canada, the USA, Australia, New Zealand, the UK and leading European countries.</span></li>
<li><i><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m20 6-11 11-5-5"/></svg></i><span>A personalized and transparent process, from initial consultation right through to visa approval.</span></li>
</ul>
<a class="btn btn--primary btn--lg" href="{{ url('about-us') }}">Learn More <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14m-7-7 7 7-7 7"/></svg></a>
</div>
</div>
</div>
</section>

<section class="section section--alt services-section">
<!-- Ambient Floating Shapes -->
<div class="float-shape float-shape--ring float-slow-2" style="top:18%;left:4%;width:88px;height:88px;"></div>
<div class="float-shape float-shape--cross float-slow-1" style="bottom:16%;right:5%;"></div>
<div class="float-shape float-shape--dot float-slow-3" style="top:58%;right:3%;width:16px;height:16px;"></div>

<div class="shell" style="position:relative;z-index:2">
<div class="section-head section-head--left" data-anim="up" style="position:relative">
<div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:0.75rem;margin-bottom:0.75rem">
  <span class="eyebrow" style="margin-bottom:0">Our services</span>
  <span class="service-trust-pill"><span class="service-trust-pill__icon">★</span> RCIC &amp; MARA Certified</span>
</div>
<h2>What We <span class="accent">Do?</span></h2>
<p>Five services that carry you from your first question to your landing date.</p>
</div>
<div class="process" data-anim-group="80"><a class="process__row" href="{{ url('consultation') }}" data-anim="right">
<span class="process__num">01</span>
<div class="process__body">
<h3>Consultation</h3>
<p>Expert consultants provide valuable guidance and visa knowledge for smooth immigration process.</p>
</div>
<span class="process__go"><svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14m-7-7 7 7-7 7"/></svg></span>
</a><a class="process__row" href="{{ url('eligibility-assessment') }}" data-anim="right">
<span class="process__num">02</span>
<div class="process__body">
<h3>Eligibility Assessment</h3>
<p>Quick online assessment helps determine your visa eligibility with instant result updates.</p>
</div>
<span class="process__go"><svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14m-7-7 7 7-7 7"/></svg></span>
</a><a class="process__row" href="{{ url('application-processing') }}" data-anim="right">
<span class="process__num">03</span>
<div class="process__body">
<h3>Application Processing</h3>
<p>Professionals assist in preparing, verifying, and submitting immigration documents efficiently.</p>
</div>
<span class="process__go"><svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14m-7-7 7 7-7 7"/></svg></span>
</a><a class="process__row" href="{{ url('contact-us') }}" data-anim="right">
<span class="process__num">04</span>
<div class="process__body">
<h3>Client Assistance</h3>
<p>One-on-one support ensures safety, basic needs, and essential service connections.</p>
</div>
<span class="process__go"><svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14m-7-7 7 7-7 7"/></svg></span>
</a><a class="process__row" href="{{ url('contact-us') }}" data-anim="right">
<span class="process__num">05</span>
<div class="process__body">
<h3>Pre Landing Services</h3>
<p>Guidance for qualifications, documentation, and educational assessments before immigration journey.</p>
</div>
<span class="process__go"><svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14m-7-7 7 7-7 7"/></svg></span>
</a></div>
</div>
</section>

<section class="section section--dark why-us-section">
<!-- Dynamic Floating Glowing Blobs -->
<div class="blob blob--gold float-drift" style="width:520px;height:520px;right:-100px;bottom:-100px;opacity:0.28"></div>
<div class="blob blob--blue float-slow-2" style="width:440px;height:440px;left:-80px;top:-60px;position:absolute;border-radius:50%;background:radial-gradient(circle,rgba(47,95,168,.4),transparent 70%);pointer-events:none"></div>

<!-- Ambient Floating Shapes & Badges -->
<div class="float-shape float-shape--ring float-spin" style="top:12%;left:6%;width:75px;height:75px;border-color:rgba(240,165,0,.25)"></div>
<div class="float-shape float-shape--cross float-slow-3" style="bottom:22%;right:6%;opacity:0.6"></div>
<div class="float-badge float-badge--dark float-slow-2" style="top:25px;right:5%;"><span class="float-badge__icon">🛡️</span> 100% Legal Compliance</div>
<div class="float-badge float-badge--dark float-slow-1" style="bottom:25px;left:4%;"><span class="float-badge__icon">🌐</span> Global Representation</div>

<div class="shell" style="position:relative;z-index:1">
<div class="section-head" data-anim="up">
<span class="eyebrow eyebrow--light">Why choose us</span>
<h2>Built on credibility and expertise</h2>
<p style="color:rgba(255,255,255,.62)">Backed by a customer-first approach, we make the journey abroad smoother, faster and stress-free.</p>
</div>
<div class="feature-grid" data-anim-group="100"><article class="feature" data-anim="up">
<div class="feature__ic"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3v4m0 10v4M3 12h4m10 0h4M5.6 5.6l2.8 2.8m7.2 7.2 2.8 2.8m0-12.8-2.8 2.8m-7.2 7.2-2.8 2.8"/></svg></div>
<h3>Expert Consultants</h3>
<p>In-depth knowledge of visa application processes across multiple countries, tailored to your individual situation.</p>
</article><article class="feature" data-anim="up">
<div class="feature__ic"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg></div>
<h3>Transparent Process</h3>
<p>A personalized and transparent immigration process, so you always know exactly where your application stands.</p>
</article><article class="feature" data-anim="up">
<div class="feature__ic"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 14v-3a8 8 0 0 1 16 0v3"/><path d="M4 14a2 2 0 0 1 2-2h1v6H6a2 2 0 0 1-2-2zm16 0a2 2 0 0 0-2-2h-1v6h1a2 2 0 0 0 2-2z"/><path d="M17 18v1a3 3 0 0 1-3 3h-2"/></svg></div>
<h3>End-to-End Support</h3>
<p>From initial consultation to visa approval, our team provides guidance tailored to your profile and goals.</p>
</article><article class="feature" data-anim="up">
<div class="feature__ic"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m20 6-11 11-5-5"/></svg></div>
<h3>Qualified Professionals</h3>
<p>All immigration matters are managed by qualified professionals in accordance with each country&rsquo;s laws.</p>
</article></div>
</div>
</section>

<section class="section media-section">
<!-- Ambient Floating Shapes & Badges -->
<div class="float-shape float-shape--ring-navy float-slow-3" style="top:15%;right:5%;width:90px;height:90px;"></div>
<div class="float-shape float-shape--dot float-slow-1" style="bottom:20%;left:3%;width:14px;height:14px;"></div>
<div class="float-badge float-badge--gold float-slow-2" style="top:15px;right:4%;"><span class="float-badge__icon">📰</span> Verified Insights</div>

<div class="shell" style="position:relative;z-index:2">
<div class="section-head" data-anim="up">
<span class="eyebrow">Insights</span>
<h2>Group <span class="accent">Media</span></h2>
</div>
@include('partials.home-media')
</div>
</section>

<section class="section section--alt testimonials-section" id="testimonials">
<!-- Ambient Floating Shapes -->
<div class="float-shape float-shape--ring float-spin" style="top:14%;left:4%;width:80px;height:80px;"></div>
<div class="float-shape float-shape--cross float-slow-3" style="bottom:15%;right:5%;"></div>
<div class="float-shape float-shape--dot float-slow-2" style="top:60%;right:3%;width:15px;height:15px;"></div>

<div class="shell" style="position:relative;z-index:2">
<div class="story-panel">
<div class="story-panel__top">
  <span class="eyebrow eyebrow--light" style="margin-bottom:0">Success Story</span>
  <div class="story-panel__badges">
    <span class="story-badge story-badge--verified"><span class="story-badge__icon">✓</span> Verified Relocation</span>
    <span class="story-badge story-badge--certified"><span class="story-badge__icon">★</span> RCIC &amp; MARA Certified</span>
  </div>
</div>
<h2>Diverse Pathwais Immigration Success</h2>
<p>A leading Indian family based in Dubai trusted Diverse Pathwais to orchestrate their relocation to Canada. With proactive CRS optimization, PNP endorsement, and comprehensive documentation, their permanent residency was approved in under 6 months without delays.</p>
</div>
<div class="tstack" data-tstack data-anim="up" style="margin-top:3.5rem">
<div class="tstack__mark" aria-hidden="true">&ldquo;</div>
<div class="tstack__slide is-active">
<div class="tstack__stars" aria-label="5 out of 5 stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
<blockquote><p>&ldquo;Securing my Canada PR felt out of reach after two draw cutoffs. The consultants at Diverse Pathwais reassessed my CRS profile, guided me through the Ontario PNP tech stream, and handled my ECA documentation meticulously. Received our CoPR in just 5 months. Exceptional transparency from day one.&rdquo;</p></blockquote>
<div class="tstack__name">Rahul Sharma</div>
<div class="tstack__role">Senior Systems Architect &bull; Canada Express Entry &amp; Ontario PNP</div>
</div><div class="tstack__slide">
<div class="tstack__stars" aria-label="5 out of 5 stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
<blockquote><p>&ldquo;Navigating the genuine temporary entrant criteria and financial proof for Australia was overwhelming. Diverse Pathwais refined my Statement of Purpose sentence-by-sentence and coordinated my medicals seamlessly. My Subclass 500 visa was granted in 18 days without a single query.&rdquo;</p></blockquote>
<div class="tstack__name">Ayesha Khan</div>
<div class="tstack__role">Master of Data Science &bull; University of Melbourne, Australia</div>
</div><div class="tstack__slide">
<div class="tstack__stars" aria-label="5 out of 5 stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
<blockquote><p>&ldquo;Relocating my spouse and two children required impeccable precision. Diverse Pathwais processed our UK Skilled Worker sponsorship, dependant visas, and health clearances simultaneously with zero friction. We landed at Heathrow completely stress-free.&rdquo;</p></blockquote>
<div class="tstack__name">Mohammed Ali</div>
<div class="tstack__role">Healthcare Specialist &bull; UK Skilled Worker &amp; Family Relocation</div>
</div>
<div class="tstack__avatars" role="tablist" aria-label="Client reviews">
<button class="tstack__avatar is-active" type="button" role="tab" aria-selected="true" aria-label="Read the review from Rahul Sharma"><img src="{{ asset('assets/img/client-rahul.webp') }}" alt="Rahul Sharma" width="54" height="54"/></button>
<button class="tstack__avatar" type="button" role="tab" aria-selected="false" aria-label="Read the review from Ayesha Khan"><img src="{{ asset('assets/img/client-ayesha.webp') }}" alt="Ayesha Khan" width="54" height="54"/></button>
<button class="tstack__avatar" type="button" role="tab" aria-selected="false" aria-label="Read the review from Mohammed Ali"><img src="{{ asset('assets/img/client-mohammed.webp') }}" alt="Mohammed Ali" width="54" height="54"/></button>
</div>
</div>
</div>
</section>

<section class="section form-band" id="enquiry">
<!-- Ambient Floating Background Blobs & Shapes -->
<div class="blob blob--gold float-drift" style="width:380px;height:380px;right:-70px;bottom:-70px;position:absolute;opacity:0.18;pointer-events:none"></div>
<div class="blob blob--blue float-slow-2" style="width:320px;height:320px;left:-60px;top:-50px;position:absolute;border-radius:50%;background:radial-gradient(circle,rgba(20,57,111,.16),transparent 70%);pointer-events:none"></div>
<div class="float-shape float-shape--ring float-slow-3" style="top:12%;left:5%;width:70px;height:70px;"></div>

<div class="shell" style="position:relative;z-index:2">
<!-- Desktop Side Floating Badges -->
<div class="float-badge float-badge--gold float-badge--form-left float-slow-1"><span class="float-badge__icon">🔒</span> 100% Confidential</div>
<div class="float-badge float-badge--navy float-badge--form-right float-slow-2"><span class="float-badge__icon">⚡</span> 24h Free Assessment</div>

<div class="form-card" data-anim="up">
<div class="center form-card__head">
<span class="eyebrow">Get started</span>
<h2>Planning to Move Abroad?</h2>
<p class="lead">Share a few details and one of our licensed consultants will get back to you within 24 hours.</p>
</div>
<!-- Front-end only: wire the `action`/`method` below to your mail handler or CRM endpoint. -->
<form data-enquiry-form id="home-enquiry" action="{{ route('enquiry.store') }}" method="post" novalidate>
@csrf
<input type="hidden" name="form" value="home-enquiry"/>
<div class="form-grid">
<div class="field"><label for="home-enquiry-name">Full Name</label><input id="home-enquiry-name" name="name" type="text" placeholder="e.g. Rahul Sharma" autocomplete="name" required/><span class="error"></span></div>
<div class="field"><label for="home-enquiry-number">Phone Number</label><input id="home-enquiry-number" name="number" type="tel" placeholder="+91 98765 43210" autocomplete="tel" required/><span class="error"></span></div>
<div class="field"><label for="home-enquiry-email">Email Address</label><input id="home-enquiry-email" name="email" type="email" placeholder="name@example.com" autocomplete="email" required/><span class="error"></span></div>
<div class="field"><label for="home-enquiry-country">Country of Interest</label>
<select id="home-enquiry-country" name="country" required>
<option value="">Select a destination</option>
<option>Canada</option><option>Australia</option><option>USA</option>
<option>United Kingdom</option><option>New Zealand</option><option>Europe</option>
<option>Other</option>
</select><span class="error"></span></div>
<div class="field field--full"><label for="home-enquiry-message">Your Message / Visa Category</label><textarea id="home-enquiry-message" name="message" rows="2" placeholder="Tell us briefly about your profile or target visa..."></textarea><span class="error"></span></div>
</div>
<button class="btn btn--primary btn--lg btn--block" type="submit">Submit Free Assessment <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14m-7-7 7 7-7 7"/></svg></button>
<p class="form-status" role="status" aria-live="polite"></p>
</form>
</div>
</div>
</section>
@endsection
