<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Post;
use App\Models\Setting;
use App\Support\Seo;

class SitemapController extends Controller
{
    public function sitemap()
    {
        $urls = [];

        foreach (Page::orderByDesc('priority')->orderBy('slug')->get() as $page) {
            if (! $page->in_sitemap || ! $page->isIndexable() || ! $page->path()) {
                continue;
            }
            $urls[] = [
                'loc' => $page->canonical_url ?: Seo::absolute($page->path()),
                'lastmod' => $page->updated_at,
                'changefreq' => $page->changefreq,
                'priority' => number_format($page->priority, 1),
            ];
        }

        foreach (Post::published()->latest('published_at')->get() as $post) {
            if (! $post->in_sitemap || ! $post->isIndexable()) {
                continue;
            }
            $urls[] = [
                'loc' => $post->canonical_url ?: Seo::absolute($post->path()),
                'lastmod' => $post->updated_at,
                'changefreq' => 'weekly',
                'priority' => '0.6',
            ];
        }

        return response()
            ->view('sitemap', ['urls' => $urls])
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }

    public function robots()
    {
        $body = rtrim((string) Setting::get('robots_txt'))."\n\nSitemap: ".Seo::absolute('/sitemap.xml')."\n";

        return response($body)->header('Content-Type', 'text/plain; charset=UTF-8');
    }
}
