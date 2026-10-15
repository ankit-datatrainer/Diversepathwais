<title>{{ $seo['title'] }}</title>
@if ($seo['description'])
<meta name="description" content="{{ $seo['description'] }}"/>
@endif
@if ($seo['keywords'])
<meta name="keywords" content="{{ $seo['keywords'] }}"/>
@endif
<meta name="robots" content="{{ $seo['robots'] }}"/>
<meta name="theme-color" content="#0b2545"/>
@if ($seo['canonical'])
<link rel="canonical" href="{{ $seo['canonical'] }}"/>
@endif
<meta property="og:type" content="{{ $seo['og_type'] }}"/>
<meta property="og:site_name" content="{{ $seo['site_name'] }}"/>
<meta property="og:title" content="{{ $seo['og_title'] }}"/>
@if ($seo['og_description'])
<meta property="og:description" content="{{ $seo['og_description'] }}"/>
@endif
<meta property="og:url" content="{{ $seo['og_url'] }}"/>
<meta property="og:image" content="{{ $seo['og_image'] }}"/>
@if (!empty($seo['published_time']))
<meta property="article:published_time" content="{{ $seo['published_time'] }}"/>
<meta property="article:modified_time" content="{{ $seo['modified_time'] }}"/>
@endif
@if (!empty($seo['section']))
<meta property="article:section" content="{{ $seo['section'] }}"/>
@endif
<meta name="twitter:card" content="summary_large_image"/>
@if ($seo['twitter_handle'])
<meta name="twitter:site" content="{{ $seo['twitter_handle'] }}"/>
@endif
<meta name="twitter:title" content="{{ $seo['og_title'] }}"/>
@if ($seo['og_description'])
<meta name="twitter:description" content="{{ $seo['og_description'] }}"/>
@endif
<meta name="twitter:image" content="{{ $seo['og_image'] }}"/>
@if ($v = \App\Models\Setting::get('google_site_verification'))
<meta name="google-site-verification" content="{{ $v }}"/>
@endif
@if ($v = \App\Models\Setting::get('bing_site_verification'))
<meta name="msvalidate.01" content="{{ $v }}"/>
@endif
