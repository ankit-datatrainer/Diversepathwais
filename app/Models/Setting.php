<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Throwable;

class Setting extends Model
{
    public const DEFAULTS = [
        'site_name' => 'Diverse Pathwais PVT LTD.',
        'canonical_base' => '',
        'default_og_image' => 'assets/img/Diverse-Pathwais.webp',
        'blog_title_suffix' => ' | Diverse Pathwais PVT LTD.',
        'twitter_handle' => '',
        'google_site_verification' => '',
        'bing_site_verification' => '',
        'ga4_measurement_id' => '',
        'head_code' => '',
        'body_code' => '',
        'robots_txt' => "User-agent: *\nAllow: /\nDisallow: /admin\n",
    ];

    protected $fillable = ['key', 'value'];

    /** @var array<string, string|null>|null per-request cache */
    protected static ?array $loaded = null;

    public static function get(string $key, ?string $default = null): ?string
    {
        if (static::$loaded === null) {
            try {
                static::$loaded = static::query()->pluck('value', 'key')->all();
            } catch (Throwable) {
                static::$loaded = [];
            }
        }

        $value = static::$loaded[$key] ?? null;

        return ($value === null || $value === '') ? ($default ?? self::DEFAULTS[$key] ?? null) : $value;
    }

    public static function put(string $key, ?string $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
        static::$loaded = null;
    }
}
