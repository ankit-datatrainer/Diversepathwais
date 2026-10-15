@extends('admin.layout')
@section('title', $post->exists ? 'Edit blog post' : 'New blog post')
@section('crumb')
<a href="{{ route('admin.posts.index') }}">Blogs</a> / {{ $post->exists ? \Illuminate\Support\Str::limit($post->title, 40) : 'New' }}
@endsection
@section('actions')
@if ($post->exists)<a class="btn btn--ghost" href="{{ $post->url() }}" target="_blank" rel="noopener">{{ $post->isLive() ? 'View post' : 'Preview' }}</a>@endif
@endsection

@push('head')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css"/>
@endpush
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
@endpush

@section('content')
@php
    $suffix = \App\Models\Setting::get('blog_title_suffix');
    $publishedValue = old('published_at', $post->published_at?->format('Y-m-d\TH:i'));
@endphp
<form method="post" action="{{ $post->exists ? route('admin.posts.update', $post) : route('admin.posts.store') }}" enctype="multipart/form-data" data-track>
@csrf
@if ($post->exists) @method('PUT') @endif
<div class="grid grid--main">
<div class="grid">
<div class="card">
<nav class="tabs" data-tabs>
<button type="button" class="is-active" data-tab="content">Content</button>
<button type="button" data-tab="search">SEO</button>
<button type="button" data-tab="social">Social sharing</button>
<button type="button" data-tab="advanced">Advanced</button>
</nav>

<div class="tab-panel is-active" data-panel="content">
<div class="card__body">
<div class="form-grid">
<div class="field field--full {{ $errors->has('title') ? 'has-error' : '' }}">
<label for="title">Title</label>
<input id="title" name="title" type="text" value="{{ old('title', $post->title) }}" required placeholder="e.g. How to apply for a Canada student visa"/>
@error('title')<span class="error">{{ $message }}</span>@enderror
</div>
<div class="field field--full {{ $errors->has('slug') ? 'has-error' : '' }}">
<label for="slug">URL slug</label>
<div class="prefix"><span>{{ rtrim(\App\Support\Seo::absolute('/'), '/') }}/blog/</span><input id="slug" name="slug" type="text" value="{{ old('slug', $post->slug) }}" placeholder="auto-generated-from-title"/></div>
<span class="hint">Lower-case words separated by hyphens. Changing the slug of a published post changes its URL.</span>
@error('slug')<span class="error">{{ $message }}</span>@enderror
</div>
<div class="field field--full {{ $errors->has('excerpt') ? 'has-error' : '' }}">
<label for="excerpt">Excerpt <span class="counter" data-counter-for="excerpt"></span></label>
<textarea id="excerpt" name="excerpt" rows="3" maxlength="600" data-count="80,200" placeholder="A short summary shown on the blog list and under the article title.">{{ old('excerpt', $post->excerpt) }}</textarea>
</div>
<div class="field field--full {{ $errors->has('content') ? 'has-error' : '' }}">
<label>Article content</label>
<div id="editor" data-upload="{{ route('admin.posts.upload') }}"></div>
<textarea id="content" name="content" hidden>{{ old('content', $post->content) }}</textarea>
<span class="hint">Use H2/H3 headings to structure the article. The image button uploads pictures to the server.</span>
</div>
</div>
</div>
</div>

@include('admin.partials.seo-fields', [
    'model' => $post,
    'firstPanel' => 'content',
    'fallbackTitle' => ($post->title ?: 'Post title').$suffix,
    'ogFallbackHint' => ' If empty, the featured image is used.',
    'schemaHint' => 'Optional. BlogPosting and BreadcrumbList schema are generated automatically — only paste JSON here to override them (e.g. FAQPage or HowTo).',
])
</div>
<div class="savebar">
<button class="btn btn--primary" type="submit">{{ $post->exists ? 'Save changes' : 'Create post' }}</button>
<a class="btn btn--ghost" href="{{ route('admin.posts.index') }}">Cancel</a>
<span class="dirty"><i></i>Unsaved changes · <kbd>Ctrl S</kbd></span><span class="muted">{{ $post->exists ? 'Saved '.$post->updated_at->diffForHumans() : 'Not saved yet' }}</span>
</div>
</div>

<div class="grid sticky">
<div class="card">
<div class="card__head"><h2>Publish</h2></div>
<div class="card__body" style="display:grid;gap:16px">
<div class="field">
<label for="status">Status</label>
<select id="status" name="status">
<option value="draft" @selected(old('status', $post->status) === 'draft')>Draft — hidden from the website</option>
<option value="published" @selected(old('status', $post->status) === 'published')>Published</option>
</select>
</div>
<div class="field {{ $errors->has('published_at') ? 'has-error' : '' }}">
<label for="published_at">Publish date</label>
<input id="published_at" name="published_at" type="datetime-local" value="{{ $publishedValue }}"/>
<span class="hint">Leave empty to publish now. A future date schedules the post.</span>
</div>
<div class="field">
<label for="category">Category</label>
<input id="category" name="category" type="text" list="category-list" value="{{ old('category', $post->category) }}" placeholder="e.g. Study Abroad"/>
<datalist id="category-list">@foreach ($categories as $c)<option value="{{ $c }}">@endforeach</datalist>
</div>
<div class="field">
<label for="tags">Tags</label>
<input id="tags" name="tags" type="text" value="{{ old('tags', $post->tags) }}" placeholder="Canada, student visa, IELTS"/>
</div>
<div class="field">
<label for="author_name">Author</label>
<input id="author_name" name="author_name" type="text" value="{{ old('author_name', $post->author_name) }}"/>
</div>
<div class="field {{ $errors->has('featured_image_file') ? 'has-error' : '' }}">
<label for="featured_image_file">Featured image</label>
<div class="img-preview" style="flex-direction:column;align-items:stretch">
<img id="featured-preview" src="{{ $post->featured_image ? $post->imageUrl() : '' }}" alt="" style="width:100%;height:150px" @if (!$post->featured_image) hidden @endif/>
<input id="featured_image_file" name="featured_image_file" type="file" accept="image/png,image/jpeg,image/webp,image/gif" data-preview="featured-preview"/>
@if ($post->featured_image)
<label class="check" style="font-weight:500"><input type="checkbox" name="remove_featured_image" value="1"/> Remove image</label>
@endif
</div>
@error('featured_image_file')<span class="error">{{ $message }}</span>@enderror
</div>
<div class="field">
<label for="featured_image_alt">Image alt text</label>
<input id="featured_image_alt" name="featured_image_alt" type="text" value="{{ old('featured_image_alt', $post->featured_image_alt) }}" placeholder="Describe the image for accessibility and SEO"/>
</div>
@if ($post->exists)
<div class="muted" style="font-size:12.5px">Created {{ $post->created_at->format('M j, Y') }} · Updated {{ $post->updated_at->diffForHumans() }} · {{ number_format($post->views) }} views · {{ $post->wordCount() }} words</div>
@endif
</div>
</div>
@include('admin.partials.seo-preview', [
    'path' => '/blog/'.($post->slug ?: 'your-post-url'),
    'fallbackTitle' => ($post->title ?: 'Post title').$suffix,
    'fallbackDesc' => $post->summary(158),
    'titleSuffix' => $suffix,
    'analysis' => $analysis,
    'socialImage' => \App\Support\Seo::absolute($post->og_image ?: ($post->featured_image ?: \App\Models\Setting::get('default_og_image'))),
])
</div>
</div>
</form>
@if ($post->exists)
<form method="post" action="{{ route('admin.posts.destroy', $post) }}" data-confirm="Delete this blog post permanently?" style="margin-top:-6px">@csrf @method('DELETE')<button class="btn btn--danger btn--sm" type="submit">Delete this post</button></form>
@endif
@endsection
