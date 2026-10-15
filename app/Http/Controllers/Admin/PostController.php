<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesSeoFields;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Support\SeoAnalyzer;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PostController extends Controller
{
    use HandlesSeoFields;

    public function index(Request $request)
    {
        $status = $request->query('status');
        $search = trim((string) $request->query('q'));

        $posts = Post::query()
            ->when($status === 'published', fn ($q) => $q->published())
            ->when($status === 'draft', fn ($q) => $q->where('status', 'draft'))
            ->when($status === 'scheduled', fn ($q) => $q->where('status', 'published')->where('published_at', '>', now()))
            ->when($search !== '', fn ($q) => $q->where(fn ($w) => $w->where('title', 'like', "%{$search}%")->orWhere('slug', 'like', "%{$search}%")))
            ->latest('updated_at')
            ->paginate(15)
            ->withQueryString();

        $posts->getCollection()->transform(function ($p) {
            $p->analysis = SeoAnalyzer::post($p);

            return $p;
        });

        return view('admin.posts.index', [
            'posts' => $posts,
            'status' => $status,
            'search' => $search,
            'counts' => [
                'all' => Post::count(),
                'published' => Post::published()->count(),
                'draft' => Post::where('status', 'draft')->count(),
                'scheduled' => Post::where('status', 'published')->where('published_at', '>', now())->count(),
            ],
        ]);
    }

    public function create()
    {
        $post = new Post(['status' => 'draft', 'robots' => 'index, follow', 'in_sitemap' => true, 'author_name' => auth()->user()->name]);

        return $this->form($post);
    }

    public function store(Request $request)
    {
        $post = new Post;
        $post->fill($this->validated($request, $post))->save();

        return redirect()->route('admin.posts.edit', $post)->with('status', 'Blog post created.');
    }

    public function edit(Post $post)
    {
        return $this->form($post);
    }

    public function update(Request $request, Post $post)
    {
        $post->fill($this->validated($request, $post))->save();

        return redirect()->route('admin.posts.edit', $post)->with('status', 'Blog post saved.');
    }

    public function destroy(Post $post)
    {
        foreach (array_filter([$post->featured_image, $post->og_image]) as $img) {
            if (Str::startsWith($img, 'uploads/')) {
                File::delete(public_path($img));
            }
        }
        $post->delete();

        return redirect()->route('admin.posts.index')->with('status', 'Blog post deleted.');
    }

    /** Image upload endpoint used by the rich-text editor. */
    public function uploadImage(Request $request)
    {
        $request->validate(['image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:4096']]);

        return response()->json(['url' => asset($this->storeUpload($request->file('image'), 'blog'))]);
    }

    /** Live slug suggestion for the editor. */
    public function slug(Request $request)
    {
        return response()->json([
            'slug' => Post::uniqueSlug((string) $request->query('title'), $request->integer('ignore') ?: null),
        ]);
    }

    protected function form(Post $post)
    {
        return view('admin.posts.form', [
            'post' => $post,
            'analysis' => $post->exists ? SeoAnalyzer::post($post) : null,
            'robotsOptions' => self::ROBOTS,
            'categories' => Post::whereNotNull('category')->distinct()->orderBy('category')->pluck('category'),
        ]);
    }

    protected function validated(Request $request, Post $post): array
    {
        $request->merge(['slug' => Str::slug((string) ($request->input('slug') ?: $request->input('title')))]);

        $v = $request->validate($this->seoRules() + [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'alpha_dash', Rule::unique('posts', 'slug')->ignore($post->id)],
            'excerpt' => ['nullable', 'string', 'max:600'],
            'content' => ['nullable', 'string'],
            'featured_image_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:4096'],
            'remove_featured_image' => ['nullable', 'boolean'],
            'featured_image_alt' => ['nullable', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:100'],
            'tags' => ['nullable', 'string', 'max:500'],
            'author_name' => ['nullable', 'string', 'max:120'],
            'status' => ['required', 'in:draft,published'],
            'published_at' => ['nullable', 'date'],
        ], [
            'slug.unique' => 'Another post already uses this URL slug.',
        ]);

        $data = collect($v)->only([
            'title', 'slug', 'excerpt', 'content', 'featured_image_alt', 'category', 'tags', 'author_name', 'status',
        ])->all();

        // strip the empty paragraph the editor leaves behind
        if (isset($data['content']) && trim(strip_tags($data['content'], '<img>')) === '') {
            $data['content'] = null;
        }

        $publishedAt = $v['published_at'] ?? null;
        $data['published_at'] = $publishedAt ? Carbon::parse($publishedAt) : ($v['status'] === 'published' ? ($post->published_at ?? now()) : $post->published_at);

        if ($request->hasFile('featured_image_file')) {
            $data['featured_image'] = $this->storeUpload($request->file('featured_image_file'), 'blog');
        } elseif ($request->boolean('remove_featured_image')) {
            $data['featured_image'] = null;
        }

        return $data + $this->seoData($request, $v, $post->og_image);
    }
}
