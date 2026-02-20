<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\SeoCity;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function suggest(Request $request)
    {
        $query = $request->get('q');
        if (strlen($query) < 2) return response()->json([]);

        // Search in Services
        $services = Service::where('name', 'LIKE', "%{$query}%")
            ->limit(3)
            ->get()
            ->map(function ($s) {
                return [
                    'type' => 'Service',
                    'title' => $s->name,
                    'url' => route('services'), // Ideally link to detail, but this is a start
                    'snippet' => "Solusi tuntas untuk {$s->name} tanp bongkar."
                ];
            });

        // Search in Cities
        $cities = SeoCity::where('name', 'LIKE', "%{$query}%")
            ->limit(3)
            ->get()
            ->map(function ($c) {
                return [
                    'type' => 'Area',
                    'title' => "RooterIn {$c->name}",
                    'url' => route('local.city', $c->slug),
                    'snippet' => "Layanan pipa mampet standby di wilayah {$c->name}."
                ];
            });

        return response()->json($services->merge($cities));
    }
}
