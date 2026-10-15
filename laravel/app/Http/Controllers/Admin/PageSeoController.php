<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesSeoFields;
use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Support\SeoAnalyzer;
use Illuminate\Http\Request;

class PageSeoController extends Controller
{
    use HandlesSeoFields;

    public function index()
    {
        $pages = Page::orderByRaw("slug = 'home' desc")->orderBy('name')->get()
            ->map(fn ($p) => ['page' => $p, 'analysis' => SeoAnalyzer::page($p)]);

        return view('admin.pages.index', ['pages' => $pages]);
    }

    public function edit(Page $page)
    {
        return view('admin.pages.edit', [
            'page' => $page,
            'analysis' => SeoAnalyzer::page($page),
            'robotsOptions' => self::ROBOTS,
        ]);
    }

    public function update(Request $request, Page $page)
    {
        $validated = $request->validate($this->seoRules() + [
            'priority' => ['required', 'numeric', 'between:0,1'],
            'changefreq' => ['required', 'in:always,hourly,daily,weekly,monthly,yearly,never'],
        ]);

        $page->update($this->seoData($request, $validated, $page->og_image) + [
            'priority' => $validated['priority'],
            'changefreq' => $validated['changefreq'],
        ]);

        return redirect()->route('admin.pages.edit', $page)->with('status', 'SEO for “'.$page->name.'” saved.');
    }
}
