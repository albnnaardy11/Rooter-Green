<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Project;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $services = Service::where('is_active', true)->take(3)->get()->map(function ($s, $index) {
            $colors = ['primary', 'accent', 'secondary'];

            return [
                'title' => $s->name,
                'tagline' => 'TEKNOLOGI MODERN',
                'desc' => $s->description_short,
                'img' => [
                    'https://images.unsplash.com/photo-1585955123058-930415956a69?w=800&fit=crop',
                    'https://images.unsplash.com/photo-1542013936693-884638332954?w=800&fit=crop',
                    'https://images.unsplash.com/photo-1541123437800-1bb1317badc2?w=800&fit=crop'
                ][$index % 3], 
                'color' => $colors[$index % 3],
            ];
        });

        $projects = Project::latest()->take(10)->get()->map(function ($project) {
            $images = $project->images;
            return [
                'img' => $images[0] ?? '/images/placeholder.jpg',
                'title' => $project->title,
                'category' => $project->category,
            ];
        });
        
        $testimonials = Testimonial::all();

        $faqs = \App\Models\Faq::landing()->orderBy('order')->get()->map(function($f) {
            return [
                'q' => $f->question,
                'a' => $f->answer
            ];
        });

        return view('welcome', compact('services', 'projects', 'testimonials', 'faqs'));
    }
}
