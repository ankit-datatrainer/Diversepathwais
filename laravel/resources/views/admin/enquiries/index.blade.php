@extends('admin.layout')
@section('title', 'Enquiries')
@section('crumb', 'Super Admin / Enquiries')

@section('content')
<div class="card">
<div class="card__head" style="flex-wrap:wrap">
<div class="filters">
<a class="pill {{ !$form && !request('unread') ? 'is-active' : '' }}" href="{{ route('admin.enquiries.index') }}">All</a>
<a class="pill {{ request('unread') ? 'is-active' : '' }}" href="{{ route('admin.enquiries.index', ['unread' => 1]) }}">Unread</a>
@foreach ($forms as $key => $label)
<a class="pill {{ $form === $key ? 'is-active' : '' }}" href="{{ route('admin.enquiries.index', ['form' => $key]) }}">{{ $label }}</a>
@endforeach
</div>
<form class="search" method="get" action="{{ route('admin.enquiries.index') }}">
@if ($form)<input type="hidden" name="form" value="{{ $form }}"/>@endif
<input class="input" type="search" name="q" value="{{ $search }}" placeholder="Name, email or phone…"/>
<button class="btn btn--ghost" type="submit">Search</button>
</form>
</div>
<div class="card__body card__body--flush table-wrap">
@if ($enquiries->isEmpty())
<div class="empty">No enquiries found.</div>
@else
<table class="table">
<thead><tr><th>Name</th><th>Phone</th><th class="hide-sm">Country</th><th class="hide-sm">Form</th><th>Received</th><th></th></tr></thead>
<tbody>
@foreach ($enquiries as $e)
<tr class="{{ $e->is_read ? '' : 'is-unread' }}">
<td><a class="title" href="{{ route('admin.enquiries.show', $e) }}">{{ $e->name }}</a><div class="sub">{{ $e->email }}</div></td>
<td><a href="tel:{{ preg_replace('/[^0-9+]/', '', $e->phone) }}">{{ $e->phone }}</a></td>
<td class="hide-sm">{{ $e->country }}</td>
<td class="hide-sm">{{ $e->formLabel() }}</td>
<td>{{ $e->created_at->format('M j, Y g:i A') }}</td>
<td class="num"><a class="btn btn--primary btn--sm" href="{{ route('admin.enquiries.show', $e) }}">Open</a></td>
</tr>
@endforeach
</tbody>
</table>
@endif
</div>
@include('admin.partials.pager', ['paginator' => $enquiries])
</div>
@endsection
