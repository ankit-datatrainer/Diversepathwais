@extends('layouts.site')

@section('content')
<section class="section" style="padding:8rem 0">
<div class="shell center">
<span class="eyebrow">Error 404</span>
<h1 data-anim="up">The page can&rsquo;t be found.</h1>
<p class="lead" data-anim="up" style="--d:110ms;max-width:520px;margin:1.25rem auto 2.25rem">It looks like nothing was found at this location.</p>
<a class="btn btn--primary btn--lg" data-anim="up" style="--d:200ms" href="{{ url('/') }}">Back to Home <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14m-7-7 7 7-7 7"/></svg></a>
</div>
</section>
@endsection
