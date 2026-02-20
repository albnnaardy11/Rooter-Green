<?php

namespace App\Http\Controllers;

use App\Models\WikiEntity;
use App\Services\Seo\WikiSnippetGenerator;
use Illuminate\Http\Request;
use Artesaos\SEOTools\Facades\SEOTools;
use Spatie\SchemaOrg\Schema as SchemaOrg;
use Illuminate\Support\Facades\View;

class WikiController extends Controller
{
    public function index()
    {
        $entities = WikiEntity::orderBy('title')->get();
        $categories = WikiEntity::select('category')->distinct()->pluck('category')->toArray();
        array_unshift($categories, 'Semua');
        
        SEOTools::setTitle('WikiPipa - Database Infrastruktur Saluran & Pipa');
        SEOTools::setDescription('Pelajari berbagai jenis pipa, alat plumbing, dan solusi mampet melalui database teknis WikiPipa dari RooterIn.');

        return view('wiki.index', compact('entities', 'categories'));
    }

    public function show($slug, WikiSnippetGenerator $snippetGenerator)
    {
        $entity = WikiEntity::where('slug', $slug)->firstOrFail();

        SEOTools::setTitle("{$entity->title} - WikiPipa RooterIn");
        SEOTools::setDescription(substr($entity->description, 0, 160));

        // 1. Semantic Entity Schema (TechArticle for Technical Otoritas)
        $schema = SchemaOrg::techArticle()
            ->headline($entity->title)
            ->description($entity->description)
            ->proficiencyLevel('Professional')
            ->author(SchemaOrg::organization()->name('RooterIN Tech Team'));

        if ($entity->wikidata_id) {
            $schema->sameAs("https://www.wikidata.org/wiki/{$entity->wikidata_id}");
        }

        // 2. Featured Snippet Engine: FAQ & HowTo
        $faqSchema = $snippetGenerator->generateFaqSchema($entity);
        $howToSchema = $snippetGenerator->generateHowToSchema($entity);

        $jsonLd = $schema->toScript() . "\n" . $faqSchema->toScript();
        if ($howToSchema) {
            $jsonLd .= "\n" . $howToSchema->toScript();
        }

        View::share('entitySchema', $jsonLd);

        return view('wiki.show', compact('entity'));
    }
}
