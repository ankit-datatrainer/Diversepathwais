{{-- SEO tab panels shared by Pages SEO and Blog editors. Expects $model, $robotsOptions. --}}
<div class="tab-panel {{ ($firstPanel ?? 'search') === 'search' ? 'is-active' : '' }}" data-panel="search">
<div class="card__body">
<div class="form-grid">
<div class="field field--full {{ $errors->has('focus_keyword') ? 'has-error' : '' }}">
<label for="focus_keyword">Focus keyword</label>
<input id="focus_keyword" name="focus_keyword" type="text" value="{{ old('focus_keyword', $model->focus_keyword) }}" placeholder="e.g. student visa"/>
<span class="hint">The main search phrase this URL should rank for. Powers the SEO score checks.</span>
</div>
<div class="field field--full {{ $errors->has('meta_title') ? 'has-error' : '' }}">
<label for="meta_title">SEO title <span class="counter" data-counter-for="meta_title"></span></label>
<input id="meta_title" name="meta_title" type="text" maxlength="255" value="{{ old('meta_title', $model->meta_title) }}" data-count="30,60" data-fallback="{{ $fallbackTitle ?? '' }}" placeholder="{{ $fallbackTitle ?? '' }}"/>
<span class="hint">Shown as the blue link in Google and in the browser tab. 50–60 characters is ideal.</span>
@error('meta_title')<span class="error">{{ $message }}</span>@enderror
</div>
<div class="field field--full {{ $errors->has('meta_description') ? 'has-error' : '' }}">
<label for="meta_description">Meta description <span class="counter" data-counter-for="meta_description"></span></label>
<textarea id="meta_description" name="meta_description" rows="3" maxlength="500" data-count="120,160" placeholder="Summarise the page in one or two sentences…">{{ old('meta_description', $model->meta_description) }}</textarea>
<span class="hint">The grey snippet under the title in search results. 120–160 characters is ideal.</span>
@error('meta_description')<span class="error">{{ $message }}</span>@enderror
</div>
<div class="field field--full">
<label for="meta_keywords">Meta keywords</label>
<input id="meta_keywords" name="meta_keywords" type="text" value="{{ old('meta_keywords', $model->meta_keywords) }}" placeholder="comma, separated, keywords"/>
<span class="hint">Optional. Comma-separated related phrases.</span>
</div>
</div>
</div>
</div>

<div class="tab-panel" data-panel="social">
<div class="card__body">
<div class="form-grid">
<div class="field field--full">
<label for="og_title">Social title (Open Graph / Twitter) <span class="counter" data-counter-for="og_title"></span></label>
<input id="og_title" name="og_title" type="text" maxlength="255" value="{{ old('og_title', $model->og_title) }}" data-count="20,70" placeholder="Defaults to the SEO title"/>
</div>
<div class="field field--full">
<label for="og_description">Social description <span class="counter" data-counter-for="og_description"></span></label>
<textarea id="og_description" name="og_description" rows="3" maxlength="500" data-count="60,200" placeholder="Defaults to the meta description">{{ old('og_description', $model->og_description) }}</textarea>
</div>
<div class="field field--full {{ $errors->has('og_image_file') ? 'has-error' : '' }}">
<label for="og_image_file">Social share image</label>
<div class="img-preview">
<img id="og-preview" src="{{ $model->og_image ? \App\Support\Seo::absolute($model->og_image) : '' }}" alt="" @if (!$model->og_image) hidden @endif/>
<div style="display:grid;gap:8px">
<input id="og_image_file" name="og_image_file" type="file" accept="image/png,image/jpeg,image/webp,image/gif" data-preview="og-preview" data-social/>
@if ($model->og_image)
<label class="check" style="font-weight:500"><input type="checkbox" name="remove_og_image" value="1"/> Remove this image (use the default)</label>
@endif
</div>
</div>
<span class="hint">1200 × 630 px recommended. Used by Facebook, LinkedIn, WhatsApp and X.@isset($ogFallbackHint) {{ $ogFallbackHint }}@endisset</span>
@error('og_image_file')<span class="error">{{ $message }}</span>@enderror
</div>
</div>
</div>
</div>

<div class="tab-panel" data-panel="advanced">
<div class="card__body">
<div class="form-grid">
<div class="field {{ $errors->has('robots') ? 'has-error' : '' }}">
<label for="robots">Search engine indexing (robots)</label>
<select id="robots" name="robots">
@foreach ($robotsOptions as $opt)
<option value="{{ $opt }}" @selected(old('robots', $model->robots ?: 'index, follow') === $opt)>{{ $opt }}</option>
@endforeach
</select>
<span class="hint"><code>noindex</code> hides the URL from Google.</span>
</div>
<div class="field" style="align-content:center">
<input type="hidden" name="in_sitemap" value="0"/>
<label class="check"><input type="checkbox" name="in_sitemap" value="1" @checked(old('in_sitemap', $model->in_sitemap ?? true))/> Include in XML sitemap</label>
</div>
<div class="field field--full {{ $errors->has('canonical_url') ? 'has-error' : '' }}">
<label for="canonical_url">Canonical URL</label>
<input id="canonical_url" name="canonical_url" type="url" value="{{ old('canonical_url', $model->canonical_url) }}" placeholder="Leave empty to use this page's own URL"/>
<span class="hint">Only set this if the same content lives at another URL.</span>
@error('canonical_url')<span class="error">{{ $message }}</span>@enderror
</div>
@isset($extraAdvanced){!! $extraAdvanced !!}@endisset
<div class="field field--full {{ $errors->has('schema_json') ? 'has-error' : '' }}">
<label for="schema_json">Structured data (JSON-LD)</label>
<textarea id="schema_json" name="schema_json" class="code" rows="10" data-json spellcheck="false" placeholder='{"@@context": "https://schema.org", "@@type": "FAQPage", ...}'>{{ old('schema_json', $model->schema_json) }}</textarea>
<span class="hint">{{ $schemaHint ?? 'Paste a schema.org JSON object without the <script> tag. Validate at search.google.com/test/rich-results.' }}</span>
@error('schema_json')<span class="error">{{ $message }}</span>@enderror
</div>
</div>
</div>
</div>
