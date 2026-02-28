<?php

namespace App\Services\Seo;

use App\Models\SeoSetting;
use Illuminate\Support\Facades\Cache;

class SchemaArchitectService
{
    /**
     * UNICORP-GRADE: Semantic Structured Data (Schema Architect)
     * Auto-generates JSON-LD for maximum real-estate in SERPs.
     */
    public function generateGlobalSchema()
    {
        $siteName = SeoSetting::get('site_name', config('app.name'));
        
        return [
            '@context' => 'https://schema.org',
            '@type' => 'LocalBusiness',
            'name' => $siteName,
            'image' => url('/logo-dark.png'),
            '@id' => url('/'),
            'url' => url('/'),
            'telephone' => '+6281234567890',
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => 'Jl. Pipa Mampet No. 123',
                'addressLocality' => 'Jakarta',
                'postalCode' => '12345',
                'addressCountry' => 'ID',
            ],
            'openingHoursSpecification' => [
                '@type' => 'OpeningHoursSpecification',
                'dayOfWeek' => [
                    'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'
                ],
                'opens' => '00:00',
                'closes' => '23:59',
            ]
        ];
    }

    public function generateServiceSchema($serviceName, $description, $url)
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Service',
            'name' => $serviceName,
            'description' => $description,
            'provider' => [
                '@type' => 'LocalBusiness',
                'name' => SeoSetting::get('site_name', config('app.name'))
            ],
            'url' => $url
        ];
    }

    public function generateFaqSchema(array $faqs)
    {
        $mainEntity = [];
        foreach ($faqs as $q => $a) {
            $mainEntity[] = [
                '@type' => 'Question',
                'name' => $q,
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $a
                ]
            ];
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => $mainEntity
        ];
    }

    public function renderSchema($schema)
    {
        if (empty($schema)) return '';
        return '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>';
    }
}
