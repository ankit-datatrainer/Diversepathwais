@if ($ga = \App\Models\Setting::get('ga4_measurement_id'))
<script async src="https://www.googletagmanager.com/gtag/js?id={{ $ga }}"></script>
<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());gtag('config',@json($ga));</script>
@endif
{!! \App\Models\Setting::get('head_code') !!}
