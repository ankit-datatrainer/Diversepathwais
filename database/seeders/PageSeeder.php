<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /** Starting focus keywords / meta keywords; the super admin can change them in the SEO panel. */
    protected const KEYWORDS = [
        'home' => ['immigration consultancy', 'immigration consultancy, visa consultants, skilled worker visa, student visa, family visa, visitor visa, work permit, New Delhi'],
        'about-us' => ['immigration consultancy', 'about Diverse Pathwais, immigration consultancy, visa consultants New Delhi'],
        'skilled-worker-visa' => ['skilled worker visa', 'skilled worker visa, skilled migration, permanent residency, points based immigration'],
        'student-visa' => ['student visa', 'student visa, study visa, study abroad, university admission, student visa consultants'],
        'family-visa' => ['family visa', 'family visa, spousal visa, family reunification, dependent visa'],
        'visitor-visa' => ['visitor visa', 'visitor visa, tourist visa, temporary resident visa, business visit visa'],
        'work-permit' => ['work permit', 'work permit, work visa, employer sponsored visa, overseas jobs'],
        'consultation' => ['consultation', 'immigration consultation, visa consultation, immigration consultants'],
        'eligibility-assessment' => ['eligibility assessment', 'visa eligibility assessment, immigration eligibility check, free assessment'],
        'application-processing' => ['application processing', 'visa application processing, immigration application, document preparation'],
        'contact-us' => ['contact', 'contact Diverse Pathwais, immigration consultants New Delhi, visa consultants Connaught Place'],
    ];

    public function run(): void
    {
        $rows = json_decode(file_get_contents(__DIR__.'/data/pages.json'), true);

        $rows[] = [
            'slug' => 'blog',
            'name' => 'Blog',
            'view' => 'blog.index',
            'nav' => 'blog',
            'meta_title' => 'Immigration Blog — Visa Guides & News | Diverse Pathwais',
            'meta_description' => 'Read the Diverse Pathwais immigration blog for expert visa guides, study abroad advice, skilled migration updates and practical tips for moving abroad.',
            'og_image' => 'assets/img/Diverse-Pathwais.webp',
            'schema_json' => null,
            'robots' => 'index, follow',
            'in_sitemap' => true,
            'priority' => 0.8,
            'focus' => 'immigration blog',
            'keywords' => 'immigration blog, visa guides, study abroad tips, immigration news',
            'changefreq' => 'weekly',
        ];

        foreach ($rows as $row) {
            $page = Page::firstOrNew(['slug' => $row['slug']]);
            // structural fields always follow the code; SEO fields are only set on first seed
            $page->fill([
                'name' => $row['name'],
                'view' => $row['view'],
                'nav' => $row['nav'] ?: null,
            ]);

            if (! $page->exists) {
                [$focus, $keywords] = self::KEYWORDS[$row['slug']] ?? [$row['focus'] ?? null, $row['keywords'] ?? null];
                $page->fill([
                    'meta_title' => $row['meta_title'],
                    'meta_description' => $row['meta_description'],
                    'meta_keywords' => $keywords,
                    'focus_keyword' => $focus,
                    'og_image' => $row['og_image'] ?: null,
                    'schema_json' => $row['schema_json'],
                    'robots' => $row['robots'],
                    'in_sitemap' => $row['in_sitemap'],
                    'priority' => $row['priority'],
                    'changefreq' => $row['changefreq'] ?? ($row['slug'] === 'home' ? 'weekly' : 'monthly'),
                ]);
            }

            $page->save();
        }
    }
}
