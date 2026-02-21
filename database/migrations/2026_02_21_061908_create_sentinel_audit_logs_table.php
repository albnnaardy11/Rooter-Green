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
        Schema::create('sentinel_audit_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('event_type')->index(); // SECURITY, INFRA, AI, SEO
            $table->string('severity')->default('INFO'); // INFO, WARNING, CRITICAL
            $table->json('metrics'); // Omni-Data Mapping (Latency, Memory, Hashes)
            $table->string('environment')->default('development'); // Laragon vs Production
            $table->string('node_id')->nullable(); // External Node Reference
            $table->timestamp('created_at')->useCurrent()->index();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sentinel_audit_logs');
    }
};
