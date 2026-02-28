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
        Schema::create('seo_audit_logs', function (Blueprint $table) {
            $table->id();
            $table->string('event_type')->index(); // eg: [AUTO-RESOLVED] CANNIBAL
            $table->text('description');
            $table->string('query')->nullable()->index();
            $table->string('winner_url')->nullable();
            $table->string('loser_url')->nullable();
            $table->json('previous_state')->nullable();
            $table->json('new_state')->nullable();
            $table->decimal('confidence', 5, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seo_audit_logs');
    }
};
