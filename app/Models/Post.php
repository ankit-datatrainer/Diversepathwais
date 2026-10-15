<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    protected $fillable = [
        'title', 'slug', 'excerpt', 'content', 'featured_image', 'featured_image_alt',
        'category', 'tags', 'author_name', 'status', 'published_at',
        'meta_title', 'meta_description', 'meta_keywords', 'focus_keyword',
        'canonical_url', 'og_title', 'og_description', 'og_image',
        'robots', 'schema_json', 'in_sitemap',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'in_sitemap' => 'boolean',
        ];
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function isLive(): bool
    {
        return $this->status === 'published' && $this->published_at && $this->published_at->lte(now());
    }

    public function isIndexable(): bool
    {
        return ! str_contains(strtolower((string) $this->robots), 'noindex');
    }

    public function path(): string
    {
        return '/blog/'.$this->slug;
    }

    public function url(): string
    {
        return route('blog.show', $this->slug);
    }

    public function imageUrl(): string
    {
        $img = $this->featured_image ?: 'assets/img/Diverse-Pathwais.webp';

        return Str::startsWith($img, ['http://', 'https://']) ? $img : asset($img);
    }

    public function plainText(): string
    {
        return trim(preg_replace('/\s+/', ' ', html_entity_decode(strip_tags((string) $this->content))));
    }

    public function wordCount(): int
    {
        $text = $this->plainText();

        return $text === '' ? 0 : count(preg_split('/\s+/', $text));
    }

    public function readingMinutes(): int
    {
        return max(1, (int) ceil($this->wordCount() / 220));
    }

    public function summary(int $limit = 160): string
    {
        return $this->excerpt ?: Str::limit($this->plainText(), $limit);
    }

    /** @return list<string> */
    public function tagList(): array
    {
        return array_values(array_filter(array_map('trim', explode(',', (string) $this->tags))));
    }

    /** Lower-case, hyphenated, unique slug derived from $source. */
    public static function uniqueSlug(string $source, ?int $ignoreId = null): string
    {
        $base = Str::slug($source) ?: 'post';
        $slug = $base;
        $i = 2;
        while (static::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }
}
