<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Post;
use App\Support\Seo;
use Illuminate\Http\Request;

class BlogController extends PageController
{
    public function index(Request $request)
    {
        $category = $request->query('category') ?: null;
        $posts = Post::published()
            ->when($category, fn ($q) => $q->where('category', $category))
            ->latest('published_at')
            ->paginate(9)
            ->withQueryString();

        $categories = Post::published()->whereNotNull('category')->where('category', '!=', '')
            ->selectRaw('category, count(*) as total')->groupBy('category')->orderBy('category')
            ->pluck('total', 'category');

        $page = Page::where('slug', 'blog')->first();
        $seo = Seo::forPage($page);
        if ($category) {
            $seo['title'] = $category.' Articles'.\App\Models\Setting::get('blog_title_suffix');
            $seo['og_title'] = $seo['title'];
            $seo['canonical'] = Seo::absolute('/blog?category='.urlencode($category));
            $seo['og_url'] = $seo['canonical'];
        }
        if ($posts->currentPage() > 1) {
            $seo['title'] .= ' — Page '.$posts->currentPage();
            $seo['canonical'] = Seo::absolute('/blog?'.http_build_query(array_filter(['category' => $category, 'page' => $posts->currentPage()])));
        }

        return view('blog.index', [
            'posts' => $posts,
            'categories' => $categories,
            'category' => $category,
            'seo' => $seo,
            'activeNav' => 'blog',
            'isHome' => false,
            'adminEditUrl' => $page ? $this->adminEditUrl('admin.pages.edit', $page) : null,
        ]);
    }

    public function show(string $slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        $isAdmin = auth()->user()?->isSuperAdmin();
        // drafts and scheduled posts are visible to the super admin only (preview)
        abort_unless($post->isLive() || $isAdmin, 404);

        if ($post->isLive() && ! $isAdmin) {
            $post->timestamps = false;
            $post->increment('views');
        }

        $recent = Post::published()->where('id', '!=', $post->id)->latest('published_at')->take(4)->get();
        $related = Post::published()->where('id', '!=', $post->id)
            ->when($post->category, fn ($q) => $q->orderByRaw('category = ? desc', [$post->category]))
            ->latest('published_at')->take(3)->get();

        $seo = Seo::forPost($post);
        if (! $post->isLive()) {
            $seo['robots'] = 'noindex, nofollow';
        }

        return view('blog.show', [
            'post' => $post,
            'recent' => $recent,
            'related' => $related,
            'shareUrl' => $seo['canonical'],
            'seo' => $seo,
            'activeNav' => 'blog',
            'isHome' => false,
            'adminEditUrl' => $this->adminEditUrl('admin.posts.edit', $post),
        ]);
    }
}
