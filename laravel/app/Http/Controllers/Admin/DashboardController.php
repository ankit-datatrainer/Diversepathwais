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
        $pageScores = Page::all()->map(fn ($p) => SeoAnalyzer::page($p)['score']);
        $postScores = Post::all()->map(fn ($p) => SeoAnalyzer::post($p)['score']);
        $all = $pageScores->merge($postScores);

        return view('admin.dashboard', [
            'stats' => [
                'pages' => Page::count(),
                'posts_published' => Post::published()->count(),
                'posts_draft' => Post::where('status', 'draft')->count(),
                'enquiries' => Enquiry::count(),
                'enquiries_unread' => Enquiry::where('is_read', false)->count(),
                'enquiries_week' => Enquiry::where('created_at', '>=', now()->subDays(7))->count(),
                'seo_avg' => $all->isEmpty() ? 0 : (int) round($all->avg()),
                'blog_views' => (int) Post::sum('views'),
            ],
            'recentEnquiries' => Enquiry::latest()->take(6)->get(),
            'recentPosts' => Post::latest('updated_at')->take(5)->get(),
            'checklist' => [
                ['Google Search Console verification', (bool) Setting::get('google_site_verification')],
                ['Google Analytics (GA4) connected', (bool) Setting::get('ga4_measurement_id')],
                ['Canonical domain set', (bool) Setting::get('canonical_base')],
                ['Default social share image', (bool) Setting::get('default_og_image')],
                ['XML sitemap live', true],
                ['robots.txt live', true],
            ],
        ]);
    }
}
