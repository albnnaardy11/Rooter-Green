@php
    use Spatie\SchemaOrg\Schema;

    $localBusiness = Schema::localBusiness()
        ->name('Rooterin - Solusi Saluran Mampet')
        ->description('Jasa pembersihan saluran pipa mampet teknologi modern tanpa bongkar bergaransi.')
        ->url(url('/'))
        ->telephone(\App\Models\Setting::get('whatsapp_number', '6281246668749'))
        ->address(Schema::postalAddress()
            ->streetAddress('Jl. Raya Rooterin No. 123')
            ->addressLocality('Jakarta')
            ->addressRegion('DKI Jakarta')
            ->postalCode('12345')
            ->addressCountry('ID')
        )
        ->geo(Schema::geoCoordinates()
            ->latitude('-6.2088')
            ->longitude('106.8456')
        )
        ->openingHoursSpecification(Schema::openingHoursSpecification()
            ->dayOfWeek(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'])
            ->opens(new \DateTime('00:00'))
            ->closes(new \DateTime('23:59'))
        )
        ->aggregateRating(Schema::aggregateRating()
            ->ratingValue('4.9')
            ->reviewCount('1240')
        );
@endphp

{!! $localBusiness->toScript() !!}
