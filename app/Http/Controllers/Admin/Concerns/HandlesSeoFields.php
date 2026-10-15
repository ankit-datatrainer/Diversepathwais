<?php

namespace App\Http\Controllers\Admin\Concerns;

use App\Support\Seo;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

trait HandlesSeoFields
{
    public const ROBOTS = ['index, follow', 'noindex, follow', 'index, nofollow', 'noindex, nofollow'];

    protected function seoRules(): array
    {
        return [
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'meta_keywords' => ['nullable', 'string', 'max:500'],
            'focus_keyword' => ['nullable', 'string', 'max:255'],
            'canonical_url' => ['nullable', 'url', 'max:500'],
            'og_title' => ['nullable', 'string', 'max:255'],
            'og_description' => ['nullable', 'string', 'max:500'],
            'og_image_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:4096'],
            'remove_og_image' => ['nullable', 'boolean'],
            'robots' => ['required', Rule::in(self::ROBOTS)],
            'schema_json' => ['nullable', 'string', function (string $attr, $value, Closure $fail) {
                if ($value !== null && trim($value) !== '' && ! Seo::validJson($value)) {
                    $fail('The structured data must be valid JSON ('.json_last_error_msg().').');
                }
            }],
            'in_sitemap' => ['nullable', 'boolean'],
        ];
    }

    /** Keeps only the SEO columns from validated input and handles the OG image upload. */
    protected function seoData(Request $request, array $validated, ?string $currentOgImage): array
    {
        $data = collect($validated)->only([
            'meta_title', 'meta_description', 'meta_keywords', 'focus_keyword', 'canonical_url',
            'og_title', 'og_description', 'robots', 'schema_json',
        ])->all();
        $data['in_sitemap'] = $request->boolean('in_sitemap');

        if ($request->hasFile('og_image_file')) {
            $data['og_image'] = $this->storeUpload($request->file('og_image_file'), 'seo');
        } elseif ($request->boolean('remove_og_image')) {
            $data['og_image'] = null;
        } else {
            $data['og_image'] = $currentOgImage;
        }

        return $data;
    }

    /** Saves to public/uploads/{dir} and returns the public-relative path. */
    protected function storeUpload(UploadedFile $file, string $dir): string
    {
        $folder = public_path('uploads/'.$dir);
        File::ensureDirectoryExists($folder);
        $name = now()->format('Ymd-His').'-'.Str::lower(Str::random(6)).'.'.strtolower($file->getClientOriginalExtension() ?: $file->extension());
        $file->move($folder, $name);

        return 'uploads/'.$dir.'/'.$name;
    }
}
