<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class GalleryLandingController extends Controller
{
    public function index()
    {
        $projects = Project::latest()->get()->map(function ($p) {
            $images = $p->images;
            return [
                'img' => $images[0] ?? '/images/placeholder.jpg',
                'title' => $p->title,
                'category' => $p->category,
                'location' => $p->location,
            ];
        });
        return view('galeri', compact('projects'));
    }
}
