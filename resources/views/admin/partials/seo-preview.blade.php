{{-- Live Google + social preview and the saved SEO score. Expects $path, $fallbackTitle, $fallbackDesc, $analysis (nullable), $socialImage --}}
<div class="card">
<div class="card__head"><div><h2>Google preview</h2><p>Updates as you type</p></div></div>
<div class="card__body" style="display:grid;gap:16px">
<div class="serp" data-serp data-base="{{ rtrim(\App\Support\Seo::absolute('/'), '/') }}" data-path="{{ $path }}" data-suffix="{{ $titleSuffix ?? '' }}" data-fallback-title="{{ $fallbackTitle }}" data-fallback-desc="{{ $fallbackDesc ?? '' }}">
<div class="serp__url"><i></i><span data-serp-url></span></div>
<div class="serp__title" data-serp-title></div>
<div class="serp__desc" data-serp-desc></div>
</div>
<div class="social">
<img data-social-img src="{{ $socialImage }}" alt=""/>
<div><small>{{ parse_url(\App\Support\Seo::absolute('/'), PHP_URL_HOST) }}</small><strong data-social-title></strong><p data-social-desc></p></div>
</div>
</div>
</div>

@if ($analysis)
<div class="card">
<div class="card__head">
<span class="score score--lg score--{{ $analysis['grade'] }}" style="--v:{{ $analysis['score'] }}"><span>{{ $analysis['score'] }}</span></span>
<div><h2>SEO score</h2><p>{{ $analysis['issues'] ? $analysis['issues'].' improvement'.($analysis['issues'] > 1 ? 's' : '').' suggested' : 'Everything looks great' }} · based on the last save</p></div>
</div>
<div class="card__body" style="padding-top:6px;padding-bottom:6px">
<ul class="checks">
@foreach ($analysis['checks'] as [$label, $state, $tip])
<li><span class="dot dot--{{ $state }}">{{ $state === 'pass' ? '✓' : ($state === 'warn' ? '!' : '×') }}</span><div><strong>{{ $label }}</strong><small>{{ $tip }}</small></div></li>
@endforeach
</ul>
</div>
</div>
@endif
