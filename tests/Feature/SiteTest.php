<?php

namespace Tests\Feature;

use App\Models\Enquiry;
use App\Models\Page;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class SiteTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    protected function admin(): User
    {
        return User::where('email', 'admin@diversepathwais.com')->firstOrFail();
    }

    public function test_every_static_page_renders_with_its_seo(): void
    {
        foreach (Page::all() as $page) {
            if (! $page->path() || $page->slug === 'blog') {
                continue;
            }
            $this->get($page->path())
                ->assertOk()
                ->assertSee('<title>'.e($page->meta_title).'</title>', false)
                ->assertSee('class="flight-loader"', false)
                ->assertSee('assets/js/flight.js', false)
                ->assertSee('<main id="main">', false);
        }
    }

    public function test_home_shows_latest_blog_posts_and_schema(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('application/ld+json', false)
            ->assertSee('ProfessionalService', false)
            ->assertSee('/blog/continuous-learning-beginners-to-global-professionals', false)
            ->assertSee('id="testimonials"', false)
            ->assertSee('<footer class="site-footer" style="position:relative;overflow:hidden">', false);

        $this->get('/about-us')->assertSee("<footer class=\"site-footer\">\n<div class=\"shell\">", false);
    }

    public function test_legacy_urls_redirect_permanently(): void
    {
        $this->get('/about-us.html')->assertRedirect('/about-us')->assertStatus(301);
        $this->get('/index.html')->assertStatus(301);
        $this->get('/contact')->assertRedirect('/contact-us');
        $this->get('/reviews')->assertStatus(301);
    }

    public function test_unknown_pages_return_styled_404(): void
    {
        $this->get('/this-page-does-not-exist')->assertNotFound()->assertSee('flight-loader', false);
        $this->get('/404')->assertNotFound();
        $this->get('/blog/missing-post')->assertNotFound();
    }

    public function test_blog_listing_filter_and_article(): void
    {
        $this->get('/blog')->assertOk()
            ->assertSee('Canada Immigration Pathways', false)
            ->assertSee('Study Abroad in Canada', false)
            ->assertSee('Continuous Learning', false);

        $this->get('/blog?category=Study+Abroad')->assertOk()
            ->assertSee('Study Abroad in Canada')
            ->assertDontSee('Continuous Learning: From Beginners');

        $post = Post::where('slug', 'study-abroad-in-canada-global-future')->first();
        $this->get('/blog/'.$post->slug)->assertOk()
            ->assertSee('<title>'.e($post->meta_title).'</title>', false)
            ->assertSee('<meta name="description" content="'.e($post->meta_description).'"/>', false)
            ->assertSee('"@type": "BlogPosting"', false)
            ->assertSee('og:type" content="article"', false);

        $this->assertSame(1, $post->fresh()->views);
    }

    public function test_drafts_are_hidden_from_visitors_but_previewable_by_admin(): void
    {
        $post = Post::create(['title' => 'Secret draft', 'slug' => 'secret-draft', 'status' => 'draft', 'content' => '<p>x</p>']);

        $this->get('/blog/secret-draft')->assertNotFound();
        $this->actingAs($this->admin())->get('/blog/secret-draft')->assertOk()->assertSee('noindex, nofollow', false);
        $this->get('/blog')->assertDontSee('Secret draft');
    }

    public function test_enquiry_forms_store_submissions(): void
    {
        $this->postJson('/enquiry', [
            'form' => 'contact-form', 'name' => 'Test Person', 'number' => '+91 98765 43210',
            'email' => 'test@example.com', 'country' => 'Canada', 'message' => 'Hello',
        ])->assertOk()->assertJson(['ok' => true]);

        $this->assertDatabaseHas('enquiries', ['email' => 'test@example.com', 'form' => 'contact-form', 'is_read' => false]);

        $this->postJson('/enquiry', ['form' => 'contact-form', 'name' => '', 'number' => 'abc', 'email' => 'bad'])
            ->assertStatus(422)->assertJsonValidationErrors(['name', 'number', 'email', 'country']);
    }

    public function test_sitemap_and_robots(): void
    {
        $this->get('/sitemap.xml')->assertOk()
            ->assertHeader('Content-Type', 'application/xml; charset=UTF-8')
            ->assertSee('/blog/canada-immigration-pathways-skilled-professionals', false)
            ->assertSee('/skilled-worker-visa', false);

        $this->get('/robots.txt')->assertOk()->assertSee('Sitemap:')->assertSee('Disallow: /admin');
    }

    public function test_admin_requires_login(): void
    {
        $this->get('/admin')->assertRedirect('/admin/login');
        $this->get('/admin/pages')->assertRedirect('/admin/login');

        $editor = User::factory()->create(['role' => 'editor']);
        $this->actingAs($editor)->get('/admin')->assertRedirect('/admin/login');
    }

    public function test_super_admin_can_log_in_with_seeded_credentials(): void
    {
        $this->post('/admin/login', ['email' => 'admin@diversepathwais.com', 'password' => 'wrong'])
            ->assertSessionHasErrors('email');

        $this->post('/admin/login', ['email' => 'admin@diversepathwais.com', 'password' => config('app.admin_password')])
            ->assertRedirect('/admin');
        $this->assertAuthenticatedAs($this->admin());
    }

    public function test_every_admin_screen_loads(): void
    {
        Enquiry::create(['form' => 'home-enquiry', 'name' => 'A', 'phone' => '9999999999', 'email' => 'a@b.co', 'country' => 'USA']);
        $this->actingAs($this->admin());

        foreach (['/admin', '/admin/seo', '/admin/seo?filter=issues', '/admin/pages', '/admin/posts', '/admin/posts/create',
            '/admin/enquiries', '/admin/enquiries/1', '/admin/settings', '/admin/account'] as $url) {
            $this->get($url)->assertOk();
        }
        foreach (Page::all() as $page) {
            $this->get(route('admin.pages.edit', $page))->assertOk()->assertSee('SEO score');
        }
        foreach (Post::all() as $post) {
            $this->get(route('admin.posts.edit', $post))->assertOk();
        }
    }

    public function test_admin_page_seo_changes_appear_on_the_website(): void
    {
        $page = Page::where('slug', 'student-visa')->first();

        $this->actingAs($this->admin())->put(route('admin.pages.update', $page), [
            'meta_title' => 'Student Visa Experts in New Delhi | Diverse Pathwais',
            'meta_description' => 'New description for the student visa page that is long enough to pass the checks easily.',
            'focus_keyword' => 'student visa',
            'robots' => 'noindex, follow',
            'in_sitemap' => '1',
            'priority' => '0.9',
            'changefreq' => 'weekly',
            'schema_json' => '{"@context":"https://schema.org","@type":"Service","name":"Student visa"}',
            'og_image_file' => UploadedFile::fake()->image('share.jpg', 1200, 630),
        ])->assertRedirect(route('admin.pages.edit', $page));

        $page->refresh();
        $this->assertStringStartsWith('uploads/seo/', $page->og_image);

        $this->get('/student-visa')
            ->assertSee('<title>Student Visa Experts in New Delhi | Diverse Pathwais</title>', false)
            ->assertSee('<meta name="robots" content="noindex, follow"/>', false)
            ->assertSee('"@type":"Service"', false)
            ->assertSee($page->og_image, false);

        // noindex pages drop out of the sitemap
        $this->get('/sitemap.xml')->assertDontSee('/student-visa<', false);

        File::delete(public_path($page->og_image));
    }

    public function test_invalid_schema_json_is_rejected(): void
    {
        $page = Page::where('slug', 'about-us')->first();
        $this->actingAs($this->admin())->put(route('admin.pages.update', $page), [
            'robots' => 'index, follow', 'priority' => '0.8', 'changefreq' => 'monthly', 'schema_json' => '{not json',
        ])->assertSessionHasErrors('schema_json');
    }

    public function test_admin_can_create_edit_and_delete_a_blog_post_with_seo(): void
    {
        $this->actingAs($this->admin());

        $this->post(route('admin.posts.store'), [
            'title' => 'Work Permit Guide 2027',
            'slug' => '',
            'excerpt' => 'Everything about work permits.',
            'content' => '<h2>Intro</h2><p>Work permit content.</p>',
            'status' => 'published',
            'category' => 'Work Abroad',
            'meta_title' => 'Work Permit Guide 2027 — Step by Step',
            'meta_description' => 'A complete work permit guide.',
            'focus_keyword' => 'work permit',
            'robots' => 'index, follow',
            'in_sitemap' => '1',
            'featured_image_file' => UploadedFile::fake()->image('cover.jpg', 1200, 700),
        ])->assertRedirect();

        $post = Post::where('title', 'Work Permit Guide 2027')->firstOrFail();
        $this->assertSame('work-permit-guide-2027', $post->slug);
        $this->assertTrue($post->isLive());

        $this->get('/blog/work-permit-guide-2027')->assertOk()
            ->assertSee('<title>Work Permit Guide 2027 — Step by Step</title>', false);

        // custom slug + duplicate slug protection
        $this->put(route('admin.posts.update', $post), [
            'title' => 'Work Permit Guide 2027', 'slug' => 'Canada Work Permit Guide', 'status' => 'published', 'robots' => 'index, follow',
        ])->assertRedirect();
        $this->assertSame('canada-work-permit-guide', $post->fresh()->slug);
        $this->get('/blog/canada-work-permit-guide')->assertOk();

        $this->put(route('admin.posts.update', $post), [
            'title' => 'X', 'slug' => 'study-abroad-in-canada-global-future', 'status' => 'published', 'robots' => 'index, follow',
        ])->assertSessionHasErrors('slug');

        $image = $post->fresh()->featured_image;
        $this->delete(route('admin.posts.destroy', $post))->assertRedirect(route('admin.posts.index'));
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
        $this->assertFileDoesNotExist(public_path($image));
    }

    public function test_editor_image_upload_and_slug_helper(): void
    {
        $this->actingAs($this->admin());
        $res = $this->post(route('admin.posts.upload'), ['image' => UploadedFile::fake()->image('inline.png')], ['Accept' => 'application/json'])
            ->assertOk()->json();
        $this->assertStringContainsString('/uploads/blog/', $res['url']);
        File::delete(public_path(substr(parse_url($res['url'], PHP_URL_PATH), 1)));

        $this->getJson(route('admin.posts.slug', ['title' => 'Visa Tips: Part One']))
            ->assertJson(['slug' => 'visa-tips-part-one']);
        // already taken by a seeded post -> unique suffix
        $this->getJson(route('admin.posts.slug', ['title' => 'Study Abroad in Canada: Global Future']))
            ->assertJson(['slug' => 'study-abroad-in-canada-global-future-2']);
    }

    public function test_global_settings_are_applied(): void
    {
        $this->actingAs($this->admin())->put(route('admin.settings.update'), [
            'site_name' => 'Diverse Pathwais PVT LTD.',
            'canonical_base' => 'https://diversepathwais.com/',
            'blog_title_suffix' => ' | DP',
            'google_site_verification' => 'abc123',
            'ga4_measurement_id' => 'G-TEST123',
            'robots_txt' => "User-agent: *\nAllow: /\n",
        ])->assertRedirect(route('admin.settings.edit'));

        $this->get('/about-us')
            ->assertSee('<link rel="canonical" href="https://diversepathwais.com/about-us"/>', false)
            ->assertSee('google-site-verification" content="abc123"', false)
            ->assertSee('gtag/js?id=G-TEST123', false);
        $this->get('/')->assertSee('<link rel="canonical" href="https://diversepathwais.com/"/>', false);
        $this->get('/robots.txt')->assertSee('Sitemap: https://diversepathwais.com/sitemap.xml');
    }

    public function test_enquiry_admin_actions(): void
    {
        $e = Enquiry::create(['form' => 'refer-form', 'name' => 'B', 'phone' => '9999999999', 'email' => 'b@b.co', 'country' => 'UK']);
        $this->actingAs($this->admin());

        $this->get(route('admin.enquiries.show', $e))->assertOk()->assertSee('b@b.co');
        $this->assertTrue($e->fresh()->is_read);
        $this->patch(route('admin.enquiries.toggle', $e))->assertRedirect();
        $this->assertFalse($e->fresh()->is_read);
        $this->delete(route('admin.enquiries.destroy', $e))->assertRedirect();
        $this->assertDatabaseMissing('enquiries', ['id' => $e->id]);
    }

    public function test_admin_can_change_password(): void
    {
        $this->actingAs($this->admin())->put(route('admin.account.update'), [
            'name' => 'Super Admin', 'email' => 'admin@diversepathwais.com',
            'current_password' => config('app.admin_password'), 'password' => 'NewPass123', 'password_confirmation' => 'NewPass123',
        ])->assertRedirect(route('admin.account.edit'));

        $this->post('/admin/logout');
        $this->post('/admin/login', ['email' => 'admin@diversepathwais.com', 'password' => 'NewPass123'])->assertRedirect('/admin');
    }
}
