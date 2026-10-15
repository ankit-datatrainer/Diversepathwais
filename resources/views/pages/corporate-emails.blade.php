@extends('layouts.site')

@section('content')
<section class="page-hero" style="background-image: url('{{ asset('assets/img/banners/banner-contact-us.jpg') }}');">
<div class="shell">
<nav class="breadcrumb" aria-label="Breadcrumb"><a href="{{ url('/') }}">Home</a><span>/</span>Corporate Emails</nav>
<div class="page-hero__content">
<span class="page-hero__eyebrow" data-anim="up">OFFICIAL DIRECTORY</span>
<h1 class="page-hero__title" data-anim="up">CORPORATE EMAILS</h1>
<p class="page-hero__lead" data-anim="up" style="--d:110ms">Direct verified communication channels for our global executive team, legal departments, and client support.</p>
</div>
</div>
</section><section class="section"><div class="shell"><div class="email-grid" data-anim-group="110"><article class="email-card" data-anim="up">
<div class="email-card__avatar">DP</div>
<h3>Diverse Pathwais Official</h3>
<a href="mailto:diversepathwise@gmail.com">diversepathwise@gmail.com</a>
</article><article class="email-card" data-anim="up">
<div class="email-card__avatar">AD</div>
<h3>Amit — Diverse Pathwais</h3>
<a href="mailto:amitdiversepathwais@gmail.com">amitdiversepathwais@gmail.com</a>
</article><article class="email-card" data-anim="up">
<div class="email-card__avatar">PO</div>
<h3>Pathwais Official</h3>
<a href="mailto:pathwaisofficial@diversepathwais.com">pathwaisofficial@diversepathwais.com</a>
</article><article class="email-card" data-anim="up">
<div class="email-card__avatar">AV</div>
<h3>Akhilesh Verma</h3>
<a href="mailto:akhileshverma@diversepathwais.com">akhileshverma@diversepathwais.com</a>
</article><article class="email-card" data-anim="up">
<div class="email-card__avatar">PC</div>
<h3>Preeti Choudhary</h3>
<a href="mailto:preetichoudhary@diversepathwais.com">preetichoudhary@diversepathwais.com</a>
</article></div></div></section>
@endsection
