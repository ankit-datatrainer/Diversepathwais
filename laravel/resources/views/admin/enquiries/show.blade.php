@extends('admin.layout')
@section('title', $enquiry->name)
@section('crumb')
<a href="{{ route('admin.enquiries.index') }}">Enquiries</a> / #{{ $enquiry->id }}
@endsection

@section('content')
<div class="grid grid--main">
<div class="card">
<div class="card__head"><div class="person"><span class="avatar">{{ strtoupper(substr($enquiry->name, 0, 1)) }}</span><div><h2>{{ $enquiry->name }} <span class="badge" style="vertical-align:middle;margin-left:4px">{{ $enquiry->formLabel() }}</span></h2><p>Received {{ $enquiry->created_at->format('l, F j, Y \a\t g:i A') }} ({{ $enquiry->created_at->diffForHumans() }})</p></div></div></div>
<div class="card__body" style="display:grid;gap:20px">
<dl class="kv">
<dt>Name</dt><dd>{{ $enquiry->name }}</dd>
<dt>Phone</dt><dd><a href="tel:{{ preg_replace('/[^0-9+]/', '', $enquiry->phone) }}">{{ $enquiry->phone }}</a></dd>
<dt>Email</dt><dd><a href="mailto:{{ $enquiry->email }}">{{ $enquiry->email }}</a></dd>
<dt>Country of interest</dt><dd>{{ $enquiry->country ?: '—' }}</dd>
<dt>Submitted from</dt><dd>{{ $enquiry->page_url ?: '—' }}</dd>
</dl>
<div>
<div class="label" style="margin-bottom:8px">Message</div>
<div class="message-box">{{ $enquiry->message ?: 'No message.' }}</div>
</div>
</div>
</div>
<div class="grid">
<div class="card">
<div class="card__head"><h2>Actions</h2></div>
<div class="card__body" style="display:grid;gap:10px">
<a class="btn btn--primary btn--block" href="mailto:{{ $enquiry->email }}?subject={{ rawurlencode('Re: your enquiry with Diverse Pathwais') }}">Reply by email</a>
<a class="btn btn--gold btn--block" href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $enquiry->phone) }}" target="_blank" rel="noopener">Message on WhatsApp</a>
<form method="post" action="{{ route('admin.enquiries.toggle', $enquiry) }}">@csrf @method('PATCH')<button class="btn btn--ghost btn--block" type="submit">Mark as {{ $enquiry->is_read ? 'unread' : 'read' }}</button></form>
<form method="post" action="{{ route('admin.enquiries.destroy', $enquiry) }}" data-confirm="Delete this enquiry permanently?">@csrf @method('DELETE')<button class="btn btn--danger btn--block" type="submit">Delete enquiry</button></form>
</div>
</div>
<div class="card">
<div class="card__head"><h2>Technical details</h2></div>
<div class="card__body"><dl class="kv" style="grid-template-columns:90px 1fr;font-size:12.5px"><dt>IP</dt><dd>{{ $enquiry->ip_address ?: '—' }}</dd><dt>Browser</dt><dd>{{ $enquiry->user_agent ?: '—' }}</dd></dl></div>
</div>
</div>
</div>
@endsection
