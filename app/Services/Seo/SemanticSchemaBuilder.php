<?php

namespace App\Services\Seo;

use Spatie\SchemaOrg\Schema as SchemaOrg;
use App\Models\SeoSetting;
use App\Models\LocalizedReview;
use App\Models\Service;
use Illuminate\Support\Facades\Request;

class SemanticSchemaBuilder
{
    /**
     * Build a complex, multi-entity JSON-LD Graph.
     */
    public function buildGraph($extraData = [])
    {
        $settings = collect($extraData['settings'] ?? []);
        
        // 1. WebSite Entity
        $website = SchemaOrg::webSite()
            ->name($settings->get('site_name', config('app.name')))
            ->url(config('app.url'))
            ->potentialAction(
                SchemaOrg::searchAction()
                    ->target(url('/') . '/search?q={search_term_string}')
                    ->setProperty('query-input', 'required name=search_term_string')
            );

        // 2. Organization / LocalBusiness Entity
        $organization = SchemaOrg::localBusiness()
            ->name($settings->get('site_name', config('app.name')))
            ->description($settings->get('meta_description', ''))
            ->url(config('app.url'))
            ->telephone('0812-4666-8749')
            ->priceRange($settings->get('schema_price_range', '$$'))
            ->image(asset('images/logo.png'))
            ->address(
                SchemaOrg::postalAddress()
                    ->streetAddress($settings->get('schema_address', 'Jakarta, Indonesia'))
                    ->addressLocality('Jakarta')
                    ->addressCountry('ID')
            );

        // 3. Add Aggregated Reviews if available
        $reviewsCount = LocalizedReview::count();
        if ($reviewsCount > 5) {
            $avgRating = LocalizedReview::avg('rating') ?: 5;
            $organization->aggregateRating(
                SchemaOrg::aggregateRating()
                    ->ratingValue($avgRating)
                    ->reviewCount($reviewsCount)
                    ->bestRating(5)
                    ->worstRating(1)
            );
        }

        // 4. Handle Service specific context
        if (isset($extraData['service'])) {
            $serviceModel = $extraData['service'];
            $serviceEntity = SchemaOrg::service()
                ->name($serviceModel->name)
                ->description($serviceModel->description_short ?: $serviceModel->description)
                ->provider($organization)
                ->areaServed(SchemaOrg::city()->name('Jakarta'))
                ->hasOfferCatalog(
                    SchemaOrg::offerCatalog()
                        ->name($serviceModel->name . ' Packages')
                        ->itemListElement([
                            SchemaOrg::offer()->itemOffered(SchemaOrg::service()->name('Urgent Response'))
                        ])
                );
            
            return [$website, $organization, $serviceEntity];
        }

        // 5. FAQ Injection logic for Blog/Wiki
        if (isset($extraData['faqs'])) {
            $faqPage = SchemaOrg::fAQPage();
            $questions = [];
            foreach ($extraData['faqs'] as $q => $a) {
                $questions[] = SchemaOrg::question()
                    ->name($q)
                    ->acceptedAnswer(SchemaOrg::answer()->text($a));
            }
            $faqPage->mainEntity($questions);
            return [$website, $organization, $faqPage];
        }

        return [$website, $organization];
    }

    /**
     * Generate Hreflang tags automatically.
     */
    public function generateHreflangs()
    {
        $locales = ['id', 'en']; // Extendable
        $tags = [];
        $currentUrl = Request::url();

        foreach ($locales as $locale) {
            $tags[] = '<link rel="alternate" hreflang="' . $locale . '" href="' . $currentUrl . '?lang=' . $locale . '" />';
        }
        $tags[] = '<link rel="alternate" hreflang="x-default" href="' . $currentUrl . '" />';

        return implode("\n", $tags);
    }
}
