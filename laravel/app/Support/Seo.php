<?php

namespace App\Support;

use App\Models\Page;
use App\Models\Post;
use App\Models\Setting;
use Illuminate\Support\Str;
use Throwable;

/**
 * Builds the array the site layout turns into <title>, meta, Open Graph,
 * Twitter and JSON-LD tags. Every field the super admin leaves blank falls
 * back to a sensible derived value, so a page is never published bare.
 */
class Seo
{
    public static function absolute(?string $pathOrUrl): ?string
    {
        if (! $pathOrUrl) {
            return null;
        }
        if (Str::startsWith($pathOrUrl, ['http://', 'https://', '//'])) {
            return $pathOrUrl;
        }
        $base = rtrim((string) Setting::get('canonical_base'), '/');
        if ($base !== '') {
            return $base.'/'.ltrim($pathOrUrl, '/');
        }

        // url('/') drops the trailing slash; the homepage canonical keeps it
        return $pathOrUrl === '/' ? rtrim(url('/'), '/').'/' : url($pathOrUrl);
    }

    public static function forPage(Page|string|null $page): array
    {
        if (is_string($page)) {
            try {
                $page = Page::where('slug', $page)->first();
            } catch (Throwable) {
                $page = null;
            }
        }
        $site = Setting::get('site_name');

        if (! $page) {
            return self::finish(['title' => $site, 'robots' => 'index, follow']);
        }

        $title = $page->meta_title ?: $page->name.' | '.$site;
        $path = $page->path();

        return self::finish([
            'title' => $title,
            'description' => $page->meta_description,
            'keywords' => $page->meta_keywords,
            'robots' => $page->robots ?: 'index, follow',
            'canonical' => $page->canonical_url ?: ($path ? self::absolute($path) : null),
            'og_type' => 'website',
            'og_title' => $page->og_title,
            'og_description' => $page->og_description,
            'og_image' => $page->og_image,
            'schema' => self::validJson($page->schema_json) ? [$page->schema_json] : [],
        ]);
    }

    public static function forPost(Post $post): array
    {
        $site = Setting::get('site_name');
        $title = $post->meta_title ?: $post->title.Setting::get('blog_title_suffix');
        $description = $post->meta_description ?: $post->summary(158);
        $canonical = $post->canonical_url ?: self::absolute($post->path());
        $image = $post->og_image ?: ($post->featured_image ?: null);

        if (self::validJson($post->schema_json)) {
            $schema = [$post->schema_json];
        } else {
            $schema = [
                json_encode([
                    '@context' => 'https://schema.org',
                    '@type' => 'BlogPosting',
                    'headline' => Str::limit($post->title, 110, ''),
                    'description' => $description,
                    'image' => self::absolute($image ?: Setting::get('default_og_image')),
                    'datePublished' => optional($post->published_at)->toAtomString(),
                    'dateModified' => optional($post->updated_at)->toAtomString(),
                    'author' => ['@type' => 'Person', 'name' => $post->author_name ?: $site],
                    'publisher' => [
                        '@type' => 'Organization',
                        'name' => $site,
                        'logo' => ['@type' => 'ImageObject', 'url' => self::absolute('assets/img/DIVERSE-PATHWAIS-main-Logo-1024x534.webp')],
                    ],
                    'mainEntityOfPage' => $canonical,
                    'keywords' => $post->tags ?: $post->focus_keyword,
                ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT),
            ];
        }
        $schema[] = json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => self::absolute('/')],
                ['@type' => 'ListItem', 'position' => 2, 'name' => 'Blog', 'item' => self::absolute('/blog')],
                ['@type' => 'ListItem', 'position' => 3, 'name' => $post->title, 'item' => $canonical],
            ],
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        return self::finish([
            'title' => $title,
            'description' => $description,
            'keywords' => $post->meta_keywords ?: $post->tags,
            'robots' => $post->robots ?: 'index, follow',
            'canonical' => $canonical,
            'og_type' => 'article',
            'og_title' => $post->og_title,
            'og_description' => $post->og_description,
            'og_image' => $image,
            'published_time' => optional($post->published_at)->toAtomString(),
            'modified_time' => optional($post->updated_at)->toAtomString(),
            'section' => $post->category,
            'schema' => $schema,
        ]);
    }

    protected static function finish(array $seo): array
    {
        $seo += [
            'description' => null, 'keywords' => null, 'canonical' => null,
            'og_type' => 'website', 'og_title' => null, 'og_description' => null, 'og_image' => null,
            'schema' => [],
        ];
        $seo['site_name'] = Setting::get('site_name');
        $seo['og_title'] = $seo['og_title'] ?: $seo['title'];
        $seo['og_description'] = $seo['og_description'] ?: $seo['description'];
        $seo['og_image'] = self::absolute($seo['og_image'] ?: Setting::get('default_og_image'));
        $seo['og_url'] = $seo['canonical'] ?: url()->current();
        $seo['twitter_handle'] = Setting::get('twitter_handle');

        return $seo;
    }

    public static function validJson(?string $json): bool
    {
        if (! $json || trim($json) === '') {
            return false;
        }
        json_decode($json);

        return json_last_error() === JSON_ERROR_NONE;
    }
}
