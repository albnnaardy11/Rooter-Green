<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Artesaos\SEOTools\Facades\SEOTools;

class AiDiagnosticController extends Controller
{
    public function index()
    {
        SEOTools::setTitle('AI Visual Pipe Diagnostics - Deteksi Mampet Otomatis');
        SEOTools::setDescription('Gunakan teknologi AI (Computer Vision) Rooterin untuk mendeteksi masalah pipa Anda hanya dengan foto. Cepat, akurat, dan canggih.');
        
        return view('ai-diagnostic.index');
    }
}
