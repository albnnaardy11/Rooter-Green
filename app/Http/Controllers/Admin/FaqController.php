<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\FaqCategory;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $aboutFaqs = Faq::whereIn('placement', ['about', 'both'])->with('category')->orderBy('faq_category_id')->orderBy('order')->get();
        $landingFaqs = Faq::whereIn('placement', ['landing', 'both'])->with('category')->orderBy('faq_category_id')->orderBy('order')->get();
        
        $stats = [
            'total' => Faq::count(),
            'landing' => Faq::whereIn('placement', ['landing', 'both'])->count(),
            'about' => Faq::whereIn('placement', ['about', 'both'])->count(),
            'inactive' => Faq::where('is_active', false)->count()
        ];

        return view('admin.faqs.index', compact('aboutFaqs', 'landingFaqs', 'stats'));
    }

    public function create()
    {
        $categories = FaqCategory::all();
        return view('admin.faqs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'faq_category_id' => 'required|exists:faq_categories,id',
            'question' => 'required',
            'answer' => 'required',
            'placement' => 'required|in:about,landing,both',
            'order' => 'integer',
            'is_active' => 'boolean'
        ]);

        Faq::create($validated);

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ created successfully.');
    }

    public function edit(Faq $faq)
    {
        $categories = FaqCategory::all();
        return view('admin.faqs.edit', compact('faq', 'categories'));
    }

    public function update(Request $request, Faq $faq)
    {
        $validated = $request->validate([
            'faq_category_id' => 'required|exists:faq_categories,id',
            'question' => 'required',
            'answer' => 'required',
            'placement' => 'required|in:about,landing,both',
            'order' => 'integer',
            'is_active' => 'boolean'
        ]);

        $faq->update($validated);

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ updated successfully.');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();
        return redirect()->route('admin.faqs.index')->with('success', 'FAQ deleted successfully.');
    }
}
