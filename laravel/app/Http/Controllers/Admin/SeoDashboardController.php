<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Post;
use App\Support\SeoAnalyzer;
use Illuminate\Http\Request;

class SeoDashboardController extends Controller
{
    public function index(Request $request)
    {
        $rows = collect();

        foreach (Page::orderByRaw("slug = 'home' desc")->orderBy('name')->get() as $page) {
            $a = SeoAnalyzer::page($page);
            $rows->push([
                'type' => 'Page',
                'name' => $page->name,
                'url' => $page->path() ? url($page->path()) : null,
                'path' => $page->path() ?? '(error page)',
                'title' => $page->meta_title,
                'description' => $page->meta_description,
                'keyword' => $page->focus_keyword,
                'indexable' => $page->isIndexable(),
                'edit' => route('admin.pages.edit', $page),
                'live' => true,
            ] + $a);
        }

        foreach (Post::latest('published_at')->get() as $post) {
            $a = SeoAnalyzer::post($post);
            $rows->push([
                'type' => 'Blog',
                'name' => $post->title,
                'url' => $post->url(),
                'path' => $post->path(),
                'title' => $post->meta_title,
                'description' => $post->meta_description,
                'keyword' => $post->focus_keyword,
                'indexable' => $post->isIndexable(),
                'edit' => route('admin.posts.edit', $post),
                'live' => $post->isLive(),
            ] + $a);
        }

        $filter = $request->query('filter');
        $visible = $rows->filter(fn ($r) => match ($filter) {
            'pages' => $r['type'] === 'Page',
            'blogs' => $r['type'] === 'Blog',
            'issues' => $r['grade'] !== 'good',
            default => true,
        });

        return view('admin.seo.index', [
            'rows' => $visible,
            'filter' => $filter,
            'summary' => [
                'total' => $rows->count(),
                'avg' => $rows->isEmpty() ? 0 : (int) round($rows->avg('score')),
                'good' => $rows->where('grade', 'good')->count(),
                'ok' => $rows->where('grade', 'ok')->count(),
                'poor' => $rows->where('grade', 'poor')->count(),
                'missing_desc' => $rows->filter(fn ($r) => ! $r['description'])->count(),
                'missing_kw' => $rows->filter(fn ($r) => ! $r['keyword'])->count(),
                'noindex' => $rows->where('indexable', false)->count(),
            ],
        ]);
    }
}
