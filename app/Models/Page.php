<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    /** Pages that exist in the table for SEO but are not served by the /{slug} route. */
    public const SYSTEM_SLUGS = ['home', 'blog', '404'];

    protected $fillable = [
        'slug', 'name', 'view', 'nav',
        'meta_title', 'meta_description', 'meta_keywords', 'focus_keyword',
        'canonical_url', 'og_title', 'og_description', 'og_image',
        'robots', 'schema_json', 'in_sitemap', 'priority', 'changefreq',
    ];

    protected function casts(): array
    {
        return [
            'in_sitemap' => 'boolean',
            'priority' => 'float',
        ];
    }

    /** Site-relative path, or null for pages that have no URL of their own (404). */
    public function path(): ?string
    {
        return match ($this->slug) {
            'home' => '/',
            'blog' => '/blog',
            '404' => null,
            default => '/'.$this->slug,
        };
    }

    public function isIndexable(): bool
    {
        return ! str_contains(strtolower((string) $this->robots), 'noindex');
    }
}
