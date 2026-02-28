<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('seo_crawl_logs', function (Blueprint $table) {
            $table->id();
            $table->string('url')->index();
            $table->string('user_agent')->nullable();
            $table->integer('status_code');
            $table->boolean('is_in_sitemap')->default(false)->index();
            $table->string('action_taken')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->boolean('is_googlebot')->default(false)->index();
            $table->json('metadata')->nullable();
            $table->timestamp('crawled_at')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seo_crawl_logs');
    }
};
