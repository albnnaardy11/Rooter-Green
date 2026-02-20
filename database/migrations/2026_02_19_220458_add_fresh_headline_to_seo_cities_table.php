<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('seo_cities', function (Blueprint $table) {
            $table->string('fresh_headline')->nullable(); // For Google News freshness engine
        });
    }

    public function down(): void
    {
        Schema::table('seo_cities', function (Blueprint $table) {
            $table->dropColumn('fresh_headline');
        });
    }
};
