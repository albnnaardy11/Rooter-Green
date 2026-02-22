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
            $table->string('image_hash')->nullable()->index()->after('image_path');
        });
    }

    public function down(): void
    {
        Schema::table('ai_diagnoses', function (Blueprint $table) {
            $table->dropColumn('image_hash');
        });
    }
};
