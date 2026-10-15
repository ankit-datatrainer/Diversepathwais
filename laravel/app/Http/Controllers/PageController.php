<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Post;
use App\Support\Seo;
use Illuminate\Support\Facades\View;

class PageController extends Controller
{
    public function home()
    {
        $page = Page::where('slug', 'home')->firstOrFail();

        return $this->render($page, [
            'latestPosts' => Post::published()->latest('published_at')->take(3)->get(),
        ]);
    }

    public function show(string $slug)
    {
        abort_if(in_array($slug, Page::SYSTEM_SLUGS, true), 404);
        $page = Page::where('slug', $slug)->first();
        abort_unless($page && View::exists($page->view), 404);

        return $this->render($page);
    }

    protected function render(Page $page, array $data = [])
    {
        return view($page->view, $data + [
            'seo' => Seo::forPage($page),
            'activeNav' => $page->nav,
            'isHome' => $page->slug === 'home',
            'adminEditUrl' => $this->adminEditUrl('admin.pages.edit', $page),
        ]);
    }

    protected function adminEditUrl(string $route, $model): ?string
    {
        $user = auth()->user();

        return $user && $user->isSuperAdmin() ? route($route, $model) : null;
    }
}
