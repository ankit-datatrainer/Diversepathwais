@extends('admin.layout')
@section('title', 'My Account')
@section('crumb', 'Super Admin / Account')

@section('content')
<form method="post" action="{{ route('admin.account.update') }}" class="grid grid--2" data-track>
@csrf
@method('PUT')
<div class="card">
<div class="card__head"><div><h2>Profile</h2><p>Your login email and display name.</p></div></div>
<div class="card__body"><div class="form-grid">
<div class="field field--full {{ $errors->has('name') ? 'has-error' : '' }}"><label for="name">Name</label><input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required/></div>
<div class="field field--full {{ $errors->has('email') ? 'has-error' : '' }}"><label for="email">Email (login ID)</label><input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required/>@error('email')<span class="error">{{ $message }}</span>@enderror</div>
<div class="field field--full"><span class="hint">Role: <strong>Super Admin</strong> · Last login {{ $user->last_login_at?->diffForHumans() ?? '—' }}</span></div>
</div></div>
</div>
<div class="card">
<div class="card__head"><div><h2>Change password</h2><p>Leave blank to keep your current password.</p></div></div>
<div class="card__body"><div class="form-grid">
<div class="field field--full {{ $errors->has('current_password') ? 'has-error' : '' }}"><label for="current_password">Current password</label><input id="current_password" name="current_password" type="password" autocomplete="current-password"/>@error('current_password')<span class="error">{{ $message }}</span>@enderror</div>
<div class="field {{ $errors->has('password') ? 'has-error' : '' }}"><label for="password">New password</label><input id="password" name="password" type="password" autocomplete="new-password"/>@error('password')<span class="error">{{ $message }}</span>@enderror</div>
<div class="field"><label for="password_confirmation">Confirm new password</label><input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"/></div>
<div class="field field--full"><span class="hint">At least 8 characters with letters and numbers.</span></div>
</div></div>
</div>
<div class="savebar" style="grid-column:1/-1"><button class="btn btn--primary" type="submit">Save account</button><span class="dirty"><i></i>Unsaved changes · <kbd>Ctrl S</kbd></span><span class="muted">Password changes take effect on next login</span></div>
</form>
@endsection
