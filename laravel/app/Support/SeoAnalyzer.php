<?php

namespace App\Support;

use App\Models\Page;
use App\Models\Post;
use Illuminate\Support\Str;
use Throwable;

/**
 * On-page SEO checklist used by the SEO dashboard and the edit screens.
 * Each check is [label, status (pass|warn|fail), tip].
 */
class SeoAnalyzer
{
    public static function page(Page $page): array
    {
        $seo = Seo::forPage($page);
        $html = '';
        try {
            $rendered = view($page->view, ['seo' => $seo, 'activeNav' => $page->nav, 'isHome' => $page->slug === 'home'])->render();
            if (preg_match('/<main id="main">(.*)<\/main>/s', $rendered, $m)) {
                $html = $m[1];
            }
        } catch (Throwable) {
            // view missing or broken — content checks simply fail
        }

        return self::run([
            'title' => $page->meta_title,
            'description' => $page->meta_description,
            'keyword' => $page->focus_keyword,
            'slug' => $page->slug === 'home' ? '' : $page->slug,
            'html' => $html,
            'min_words' => 150,
            'og_image' => $page->og_image,
            'robots' => $page->robots,
            'schema' => Seo::validJson($page->schema_json),
            'schema_tip' => 'Add JSON-LD structured data (e.g. Organization, Service, FAQPage) in the Advanced tab.',
            'is_home' => $page->slug === 'home',
        ]);
    }

    public static function post(Post $post): array
    {
        return self::run([
            'title' => $post->meta_title,
            'description' => $post->meta_description,
            'keyword' => $post->focus_keyword,
            'slug' => $post->slug,
            // the article template renders the post title as the page's only <h1>
            'html' => '<h1>'.e($post->title).'</h1>'.$post->content,
            'min_words' => 300,
            'og_image' => $post->og_image ?: $post->featured_image,
            'robots' => $post->robots,
            'schema' => true, // BlogPosting + BreadcrumbList are generated automatically
            'schema_tip' => '',
            'is_home' => false,
            'excerpt' => $post->excerpt,
        ]);
    }

    protected static function run(array $d): array
    {
        $checks = [];
        $kw = Str::lower(trim((string) $d['keyword']));
        $title = (string) $d['title'];
        $desc = (string) $d['description'];
        $text = trim(preg_replace('/\s+/', ' ', html_entity_decode(strip_tags($d['html']))));
        $lowerText = Str::lower($text);
        $words = $text === '' ? 0 : count(preg_split('/\s+/', $text));

        $tLen = mb_strlen($title);
        $checks[] = $tLen === 0
            ? ['SEO title', 'fail', 'Write a custom SEO title (50–60 characters is ideal).']
            : ($tLen >= 30 && $tLen <= 65
                ? ['SEO title length ('.$tLen.' chars)', 'pass', 'Good length.']
                : ['SEO title length ('.$tLen.' chars)', 'warn', 'Aim for 30–65 characters so Google does not truncate it.']);

        $dLen = mb_strlen($desc);
        $checks[] = $dLen === 0
            ? ['Meta description', 'fail', 'Write a meta description (120–160 characters is ideal).']
            : ($dLen >= 70 && $dLen <= 165
                ? ['Meta description length ('.$dLen.' chars)', 'pass', 'Good length.']
                : ['Meta description length ('.$dLen.' chars)', 'warn', 'Aim for 70–160 characters.']);

        if ($kw === '') {
            $checks[] = ['Focus keyword', 'fail', 'Set a focus keyword to unlock keyword checks.'];
        } else {
            $checks[] = ['Focus keyword set', 'pass', '“'.$d['keyword'].'”'];
            $checks[] = Str::contains(Str::lower($title), $kw)
                ? ['Keyword in SEO title', 'pass', 'Nice.']
                : ['Keyword in SEO title', 'warn', 'Use the focus keyword in the SEO title, ideally near the start.'];
            $checks[] = Str::contains(Str::lower($desc), $kw)
                ? ['Keyword in meta description', 'pass', 'Nice.']
                : ['Keyword in meta description', 'warn', 'Mention the focus keyword in the meta description.'];
            if (! $d['is_home']) {
                $checks[] = Str::contains($d['slug'], Str::slug($kw))
                    ? ['Keyword in URL slug', 'pass', 'Nice.']
                    : ['Keyword in URL slug', 'warn', 'Include the focus keyword in the slug (e.g. /'.Str::slug($kw).').'];
            }
            $count = $kw === '' ? 0 : substr_count($lowerText, $kw);
            $checks[] = $count > 0
                ? ['Keyword in content ('.$count.'×)', 'pass', 'Nice.']
                : ['Keyword in content', 'warn', 'Use the focus keyword in the page/article body.'];
        }

        $h1 = preg_match_all('/<h1[\s>]/i', $d['html']);
        $checks[] = $h1 === 1
            ? ['Single H1 heading', 'pass', 'Exactly one H1.']
            : ['H1 headings ('.$h1.')', 'warn', 'Each page should have exactly one H1.'];

        $checks[] = $words >= $d['min_words']
            ? ['Content length ('.$words.' words)', 'pass', 'Enough text for search engines.']
            : ['Content length ('.$words.' words)', 'warn', 'Add more content — at least '.$d['min_words'].' words is recommended.'];

        preg_match_all('/<img\b[^>]*>/i', $d['html'], $imgs);
        $noAlt = 0;
        foreach ($imgs[0] as $img) {
            if (! preg_match('/\balt="[^"]+"/i', $img)) {
                $noAlt++;
            }
        }
        $checks[] = $noAlt === 0
            ? ['Image alt text', 'pass', count($imgs[0]).' image(s), all described.']
            : ['Image alt text', 'warn', $noAlt.' image(s) are missing alt text.'];

        $checks[] = $d['og_image']
            ? ['Social share image', 'pass', 'Custom Open Graph image set.']
            : ['Social share image', 'warn', 'Set an Open Graph image — the site default is used otherwise.'];

        $checks[] = str_contains(Str::lower((string) $d['robots']), 'noindex')
            ? ['Indexing', 'warn', 'This URL is set to noindex — it will not appear in Google.']
            : ['Indexing', 'pass', 'Search engines may index this URL.'];

        if ($d['schema_tip'] !== '' || $d['schema']) {
            $checks[] = $d['schema']
                ? ['Structured data (JSON-LD)', 'pass', 'Valid schema markup present.']
                : ['Structured data (JSON-LD)', 'warn', $d['schema_tip']];
        }

        $points = 0;
        foreach ($checks as $c) {
            $points += $c[1] === 'pass' ? 1 : ($c[1] === 'warn' ? 0.4 : 0);
        }
        $score = (int) round($points / count($checks) * 100);

        return [
            'score' => $score,
            'grade' => $score >= 80 ? 'good' : ($score >= 50 ? 'ok' : 'poor'),
            'checks' => $checks,
            'issues' => count(array_filter($checks, fn ($c) => $c[1] !== 'pass')),
            'words' => $words,
        ];
    }
}
