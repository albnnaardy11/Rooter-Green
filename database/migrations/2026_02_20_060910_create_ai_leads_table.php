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
        Schema::create('ai_leads', function (Blueprint $table) {
            $table->id();
            $table->string('diagnose_id')->unique();
            $table->string('material_type');
            $table->string('location_context');
            $table->string('ai_result');
            $table->integer('confidence_score');
            $table->char('severity_score', 1); // A-E
            $table->string('audio_analysis')->nullable();
            $table->text('recommended_tools')->nullable();
            $table->string('city_location')->nullable();
            $table->json('raw_survey_data')->nullable();
            $table->json('metadata')->nullable();
            $table->string('status')->default('new');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_leads');
    }
};
