<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceLandingController extends Controller
{
    public function index()
    {
        $services = Service::where('is_active', true)->get();
        return view('layanan', compact('services'));
    }
}
