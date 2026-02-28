<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FaqCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FaqCategoryController extends Controller
{
    public function index()
    {
        $categories = FaqCategory::orderBy('order')->get();
        return view('admin.faq-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.faq-categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'icon' => 'required|max:255',
            'order' => 'integer'
        ]);

        $validated['slug'] = Str::slug($request->name);
        FaqCategory::create($validated);

        return redirect()->route('admin.faq-categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(FaqCategory $faq_category)
    {
        return view('admin.faq-categories.edit', compact('faq_category'));
    }

    public function update(Request $request, FaqCategory $faq_category)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'icon' => 'required|max:255',
            'order' => 'integer'
        ]);

        $validated['slug'] = Str::slug($request->name);
        $faq_category->update($validated);

        return redirect()->route('admin.faq-categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(FaqCategory $faq_category)
    {
        $faq_category->delete();
        return redirect()->route('admin.faq-categories.index')->with('success', 'Category deleted successfully.');
    }
}
