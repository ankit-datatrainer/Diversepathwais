<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use App\Models\Page;
use App\Models\Post;
use App\Models\Setting;
use App\Support\SeoAnalyzer;

class DashboardController extends Controller
{
    public function index()
    {
        // SEO: score every page and post once
        $seoRows = collect();
        foreach (Page::all() as $p) {
            $seoRows->push(['name' => $p->name, 'edit' => route('admin.pages.edit', $p), 'type' => 'Page'] + SeoAnalyzer::page($p));
        }
        foreach (Post::all() as $p) {
            $seoRows->push(['name' => $p->title, 'edit' => route('admin.posts.edit', $p), 'type' => 'Blog'] + SeoAnalyzer::post($p));
        }

        // enquiries per day, last 14 days (grouped in PHP so it works on MySQL and SQLite)
        $from = now()->startOfDay()->subDays(13);
        $byDay = Enquiry::where('created_at', '>=', $from)->get(['created_at'])
            ->groupBy(fn ($e) => $e->created_at->toDateString())->map->count();
        $days = collect(range(0, 13))->map(function ($i) use ($from, $byDay) {
            $d = $from->copy()->addDays($i);

            return ['date' => $d, 'count' => (int) ($byDay[$d->toDateString()] ?? 0)];
        });
        $prevWeek = Enquiry::whereBetween('created_at', [now()->subDays(14), now()->subDays(7)])->count();
        $thisWeek = Enquiry::where('created_at', '>=', now()->subDays(7))->count();

        $byForm = collect(Enquiry::FORMS)->map(fn ($label, $key) => [
            'label' => $label,
            'count' => Enquiry::where('form', $key)->count(),
        ])->sortByDesc('count')->values();

        $checklist = [
            ['Google Search Console verification', (bool) Setting::get('google_site_verification')],
            ['Google Analytics (GA4) connected', (bool) Setting::get('ga4_measurement_id')],
            ['Canonical domain set', (bool) Setting::get('canonical_base')],
            ['Default social share image', (bool) Setting::get('default_og_image')],
            ['XML sitemap live', true],
            ['robots.txt live', true],
        ];

        return view('admin.dashboard', [
            'stats' => [
                'pages' => Page::count(),
                'posts_published' => Post::published()->count(),
                'posts_draft' => Post::where('status', 'draft')->count(),
                'enquiries' => Enquiry::count(),
                'enquiries_unread' => Enquiry::where('is_read', false)->count(),
                'enquiries_week' => $thisWeek,
                'enquiries_prev_week' => $prevWeek,
                'seo_avg' => $seoRows->isEmpty() ? 0 : (int) round($seoRows->avg('score')),
                'blog_views' => (int) Post::sum('views'),
            ],
            'grades' => [
                'good' => $seoRows->where('grade', 'good')->count(),
                'ok' => $seoRows->where('grade', 'ok')->count(),
                'poor' => $seoRows->where('grade', 'poor')->count(),
                'total' => $seoRows->count(),
            ],
            'needsWork' => $seoRows->sortBy('score')->take(4)->values(),
            'days' => $days,
            'byForm' => $byForm,
            'recentEnquiries' => Enquiry::latest()->take(6)->get(),
            'recentPosts' => Post::latest('updated_at')->take(4)->get(),
            'topPosts' => Post::published()->orderByDesc('views')->take(4)->get(),
            'checklist' => $checklist,
            'checklistDone' => count(array_filter($checklist, fn ($c) => $c[1])),
        ]);
    }
}
