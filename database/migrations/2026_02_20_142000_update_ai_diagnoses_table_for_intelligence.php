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
        Schema::table('ai_diagnoses', function (Blueprint $table) {
            if (!Schema::hasColumn('ai_diagnoses', 'latitude')) {
                $table->decimal('latitude', 10, 8)->nullable();
            }
            if (!Schema::hasColumn('ai_diagnoses', 'longitude')) {
                $table->decimal('longitude', 11, 8)->nullable();
            }
            if (!Schema::hasColumn('ai_diagnoses', 'final_deep_score')) {
                $table->char('final_deep_score', 1)->default('C'); // A, B, C, D, E
            }
            if (!Schema::hasColumn('ai_diagnoses', 'material_type')) {
                $table->string('material_type')->nullable();
            }
            if (!Schema::hasColumn('ai_diagnoses', 'location_context')) {
                $table->string('location_context')->nullable();
            }
            if (!Schema::hasColumn('ai_diagnoses', 'audio_label')) {
                $table->string('audio_label')->nullable();
            }
            if (!Schema::hasColumn('ai_diagnoses', 'audio_confidence')) {
                $table->integer('audio_confidence')->nullable();
            }
            if (!Schema::hasColumn('ai_diagnoses', 'survey_data')) {
                $table->json('survey_data')->nullable();
            }
            if (!Schema::hasColumn('ai_diagnoses', 'recommended_tools')) {
                $table->string('recommended_tools')->nullable();
            }
            if (!Schema::hasColumn('ai_diagnoses', 'analysis_version')) {
                $table->string('analysis_version')->default('2.0');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ai_diagnoses', function (Blueprint $table) {
            $table->dropColumn([
                'latitude', 'longitude', 'final_deep_score', 'material_type', 
                'location_context', 'audio_label', 'audio_confidence', 
                'survey_data', 'recommended_tools', 'analysis_version'
            ]);
        });
    }
};
