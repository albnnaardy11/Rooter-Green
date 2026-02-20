<?php

namespace App\Services\Seo;

use Carbon\Carbon;

class SmartPricingService
{
    /**
     * Calculates a "Contextual Price" based on time and environmental signals.
     */
    public function calculate(int $basePrice)
    {
        $now = Carbon::now();
        $discountLabel = null;
        $finalPrice = $basePrice;

        // 1. "Night Helper" Sentiment: If late at night, provide a small "Help" discount.
        if ($now->hour >= 21 || $now->hour <= 4) {
            $finalPrice = $basePrice * 0.95;
            $discountLabel = 'Emergency Care (-5%)';
        }

        // 2. Weather Signal (Mocked/Static for this demo, could be linked to Freshness Engine)
        // Let's assume if it's currently "Rainy Season" (Simulated)
        $isRainy = true; 
        if ($isRainy) {
            $finalPrice = $finalPrice * 0.90;
            $discountLabel = 'Waspada Hujan (-10%)';
        }

        return [
            'original' => $basePrice,
            'final' => round($finalPrice, -3), // Round to thousands
            'label' => $discountLabel,
            'is_dynamic' => true
        ];
    }
}
