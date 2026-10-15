<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role', 30)->default('editor')->after('password');
            $table->timestamp('last_login_at')->nullable()->after('remember_token');
        });

        // One row per static website page; the page body lives in its Blade view,
        // everything search engines read lives here so the super admin can edit it.
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('view');
            $table->string('nav', 30)->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords', 500)->nullable();
            $table->string('focus_keyword')->nullable();
            $table->string('canonical_url', 500)->nullable();
            $table->string('og_title')->nullable();
            $table->text('og_description')->nullable();
            $table->string('og_image', 500)->nullable();
            $table->string('robots', 60)->default('index, follow');
            $table->longText('schema_json')->nullable();
            $table->boolean('in_sitemap')->default(true);
            $table->decimal('priority', 2, 1)->default(0.7);
            $table->string('changefreq', 20)->default('monthly');
            $table->timestamps();
        });

        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content')->nullable();
            $table->string('featured_image', 500)->nullable();
            $table->string('featured_image_alt')->nullable();
            $table->string('category', 100)->nullable();
            $table->string('tags', 500)->nullable();
            $table->string('author_name', 120)->nullable();
            $table->string('status', 20)->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->unsignedInteger('views')->default(0);
            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords', 500)->nullable();
            $table->string('focus_keyword')->nullable();
            $table->string('canonical_url', 500)->nullable();
            $table->string('og_title')->nullable();
            $table->text('og_description')->nullable();
            $table->string('og_image', 500)->nullable();
            $table->string('robots', 60)->default('index, follow');
            $table->longText('schema_json')->nullable();
            $table->boolean('in_sitemap')->default(true);
            $table->timestamps();

            $table->index(['status', 'published_at']);
            $table->index('category');
        });

        Schema::create('enquiries', function (Blueprint $table) {
            $table->id();
            $table->string('form', 40);
            $table->string('name', 120);
            $table->string('phone', 30);
            $table->string('email', 190);
            $table->string('country', 60)->nullable();
            $table->text('message')->nullable();
            $table->string('page_url', 500)->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent', 500)->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamps();

            $table->index(['is_read', 'created_at']);
        });

        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->longText('value')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
        Schema::dropIfExists('enquiries');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('pages');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'last_login_at']);
        });
    }
};
