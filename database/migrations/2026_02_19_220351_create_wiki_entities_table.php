<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wiki_entities', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category'); // e.g., Pipa, Merk, Kimia, Alat
            $table->text('description');
            $table->string('wikidata_id')->nullable(); // Connection to Web of Data
            $table->json('attributes')->nullable(); // Technical specs
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wiki_entities');
    }
};
