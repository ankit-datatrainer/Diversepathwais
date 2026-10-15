<div class="field">
<label for="priority">Sitemap priority</label>
<select id="priority" name="priority">
@foreach (['1.0', '0.9', '0.8', '0.7', '0.6', '0.5', '0.4', '0.3', '0.2', '0.1'] as $p)
<option value="{{ $p }}" @selected(number_format((float) old('priority', $page->priority), 1) === $p)>{{ $p }}</option>
@endforeach
</select>
</div>
<div class="field">
<label for="changefreq">Change frequency</label>
<select id="changefreq" name="changefreq">
@foreach (['always', 'hourly', 'daily', 'weekly', 'monthly', 'yearly', 'never'] as $f)
<option value="{{ $f }}" @selected(old('changefreq', $page->changefreq) === $f)>{{ ucfirst($f) }}</option>
@endforeach
</select>
</div>
