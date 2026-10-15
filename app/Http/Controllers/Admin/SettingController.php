<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesSeoFields;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    use HandlesSeoFields;

    public function edit()
    {
        $values = [];
        foreach (array_keys(Setting::DEFAULTS) as $key) {
            $values[$key] = Setting::get($key);
        }

        return view('admin.settings', ['s' => $values]);
    }

    public function update(Request $request)
    {
        $v = $request->validate([
            'site_name' => ['required', 'string', 'max:120'],
            'canonical_base' => ['nullable', 'url', 'max:255'],
            'blog_title_suffix' => ['nullable', 'string', 'max:120'],
            'twitter_handle' => ['nullable', 'string', 'max:60'],
            'google_site_verification' => ['nullable', 'string', 'max:255'],
            'bing_site_verification' => ['nullable', 'string', 'max:255'],
            'ga4_measurement_id' => ['nullable', 'string', 'max:40', 'regex:/^G-[A-Z0-9]+$/i'],
            'head_code' => ['nullable', 'string', 'max:20000'],
            'body_code' => ['nullable', 'string', 'max:20000'],
            'robots_txt' => ['required', 'string', 'max:5000'],
            'default_og_image_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ], [
            'ga4_measurement_id.regex' => 'The GA4 Measurement ID looks like G-XXXXXXXXXX.',
        ]);

        foreach ($v as $key => $value) {
            if ($key === 'default_og_image_file') {
                continue;
            }
            Setting::put($key, $key === 'canonical_base' ? rtrim((string) $value, '/') : $value);
        }
        if ($request->hasFile('default_og_image_file')) {
            Setting::put('default_og_image', $this->storeUpload($request->file('default_og_image_file'), 'seo'));
        }

        return redirect()->route('admin.settings.edit')->with('status', 'Global SEO settings saved.');
    }
}
