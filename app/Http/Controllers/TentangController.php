<?php

namespace App\Http\Controllers;

use App\Models\FaqCategory;
use Illuminate\Http\Request;

class TentangController extends Controller
{
    public function index()
    {
        $faqCategories = FaqCategory::with(['faqs' => function($query) {
            $query->about()->orderBy('order');
        }])->orderBy('order')->get()->filter(function($cat) {
            return $cat->faqs->count() > 0;
        })->values();

        // Map to format expected by component
        $categories = $faqCategories->map(function($cat) {
            return [
                'id' => $cat->slug,
                'label' => $cat->name,
                'icon' => $cat->icon,
                'faqs' => $cat->faqs->map(function($faq) {
                    return [
                        'q' => $faq->question,
                        'a' => $faq->answer
                    ];
                })->toArray()
            ];
        })->toArray();

        return view('tentang', compact('categories'));
    }
}
