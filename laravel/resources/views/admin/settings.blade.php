@extends('admin.layout')
@section('title', 'Global SEO Settings')
@section('crumb', 'Super Admin / Settings')

@section('content')
<form method="post" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="grid">
@csrf
@method('PUT')
<div class="grid grid--2">
<div class="card">
<div class="card__head"><div><h2>Site identity</h2><p>Used in titles, Open Graph tags and structured data.</p></div></div>
<div class="card__body"><div class="form-grid">
<div class="field field--full {{ $errors->has('site_name') ? 'has-error' : '' }}">
<label for="site_name">Site name</label>
<input id="site_name" name="site_name" type="text" value="{{ old('site_name', $s['site_name']) }}" required/>
</div>
<div class="field field--full {{ $errors->has('canonical_base') ? 'has-error' : '' }}">
<label for="canonical_base">Canonical domain</label>
<input id="canonical_base" name="canonical_base" type="url" value="{{ old('canonical_base', $s['canonical_base']) }}" placeholder="https://diversepathwais.com"/>
<span class="hint">Your live domain. Canonical URLs, Open Graph URLs and the sitemap use it. Leave empty while testing locally.</span>
@error('canonical_base')<span class="error">{{ $message }}</span>@enderror
</div>
<div class="field field--full">
<label for="blog_title_suffix">Blog title suffix</label>
<input id="blog_title_suffix" name="blog_title_suffix" type="text" value="{{ old('blog_title_suffix', $s['blog_title_suffix']) }}"/>
<span class="hint">Appended to a blog post's title when it has no custom SEO title. Include the leading separator, e.g. <code> | Diverse Pathwais PVT LTD.</code></span>
</div>
<div class="field field--full">
<label for="twitter_handle">X (Twitter) handle</label>
<input id="twitter_handle" name="twitter_handle" type="text" value="{{ old('twitter_handle', $s['twitter_handle']) }}" placeholder="@diversepathwais"/>
</div>
<div class="field field--full {{ $errors->has('default_og_image_file') ? 'has-error' : '' }}">
<label for="default_og_image_file">Default social share image</label>
<div class="img-preview">
<img id="default-og" src="{{ \App\Support\Seo::absolute($s['default_og_image']) }}" alt=""/>
<input id="default_og_image_file" name="default_og_image_file" type="file" accept="image/png,image/jpeg,image/webp" data-preview="default-og"/>
</div>
<span class="hint">Used for any page or post without its own share image. 1200 × 630 px recommended.</span>
@error('default_og_image_file')<span class="error">{{ $message }}</span>@enderror
</div>
</div></div>
</div>

<div class="card">
<div class="card__head"><div><h2>Search engines &amp; analytics</h2><p>Verification tags are added to the &lt;head&gt; of every page.</p></div></div>
<div class="card__body"><div class="form-grid">
<div class="field field--full">
<label for="google_site_verification">Google Search Console verification code</label>
<input id="google_site_verification" name="google_site_verification" type="text" value="{{ old('google_site_verification', $s['google_site_verification']) }}" placeholder="content value of the google-site-verification meta tag"/>
</div>
<div class="field field--full">
<label for="bing_site_verification">Bing Webmaster verification code</label>
<input id="bing_site_verification" name="bing_site_verification" type="text" value="{{ old('bing_site_verification', $s['bing_site_verification']) }}" placeholder="content value of the msvalidate.01 meta tag"/>
</div>
<div class="field field--full {{ $errors->has('ga4_measurement_id') ? 'has-error' : '' }}">
<label for="ga4_measurement_id">Google Analytics 4 Measurement ID</label>
<input id="ga4_measurement_id" name="ga4_measurement_id" type="text" value="{{ old('ga4_measurement_id', $s['ga4_measurement_id']) }}" placeholder="G-XXXXXXXXXX"/>
@error('ga4_measurement_id')<span class="error">{{ $message }}</span>@enderror
</div>
<div class="field field--full">
<label>Live files</label>
<div style="display:flex;gap:8px;flex-wrap:wrap"><a class="btn btn--ghost btn--sm" href="{{ route('sitemap') }}" target="_blank" rel="noopener">View sitemap.xml</a><a class="btn btn--ghost btn--sm" href="{{ route('robots') }}" target="_blank" rel="noopener">View robots.txt</a></div>
<span class="hint">Submit <code>{{ \App\Support\Seo::absolute('/sitemap.xml') }}</code> in Google Search Console.</span>
</div>
</div></div>
</div>
</div>

<div class="grid grid--2">
<div class="card">
<div class="card__head"><div><h2>robots.txt</h2><p>The sitemap line is appended automatically.</p></div></div>
<div class="card__body"><div class="field {{ $errors->has('robots_txt') ? 'has-error' : '' }}">
<textarea name="robots_txt" class="code" rows="9" spellcheck="false" aria-label="robots.txt">{{ old('robots_txt', $s['robots_txt']) }}</textarea>
</div></div>
</div>
<div class="card">
<div class="card__head"><div><h2>Custom code</h2><p>For tracking pixels or chat widgets. Only paste code from sources you trust.</p></div></div>
<div class="card__body"><div class="form-grid">
<div class="field field--full"><label for="head_code">Before &lt;/head&gt;</label><textarea id="head_code" name="head_code" class="code" rows="4" spellcheck="false" style="min-height:90px">{{ old('head_code', $s['head_code']) }}</textarea></div>
<div class="field field--full"><label for="body_code">Before &lt;/body&gt;</label><textarea id="body_code" name="body_code" class="code" rows="4" spellcheck="false" style="min-height:90px">{{ old('body_code', $s['body_code']) }}</textarea></div>
</div></div>
</div>
</div>
<div class="form-actions"><button class="btn btn--primary" type="submit">Save settings</button></div>
</form>
@endsection
