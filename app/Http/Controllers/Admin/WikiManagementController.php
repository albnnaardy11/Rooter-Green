<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WikiEntity;
use App\Services\Seo\WikiAiService;
use Illuminate\Http\Request;

class WikiManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = WikiEntity::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('wikidata_id', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        $entities = $query->orderByDesc('created_at')->paginate(20);
        $categories = WikiEntity::select('category')->distinct()->pluck('category');

        return view('admin.wiki.index', compact('entities', 'categories'));
    }

    public function create()
    {
        return view('admin.wiki.form', [
            'entity' => new WikiEntity(),
            'isEdit' => false
        ]);
    }

    public function edit(WikiEntity $entity)
    {
        return view('admin.wiki.form', [
            'entity' => $entity,
            'isEdit' => true
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:wiki_entities,title',
            'category' => 'required',
            'description' => 'required',
        ]);

        $data = $request->all();
        if ($request->has('attributes_json')) {
            $data['attributes'] = json_decode($request->attributes_json, true);
        }

        WikiEntity::create($data);

        return redirect()->route('admin.wiki.index')->with('success', 'Entitas Wiki berhasil diinjeksikan ke Database Pengetahuan.');
    }

    public function update(Request $request, WikiEntity $entity)
    {
        $request->validate([
            'title' => 'required|unique:wiki_entities,title,' . $entity->id,
            'category' => 'required',
            'description' => 'required',
        ]);

        $data = $request->all();
        if ($request->has('attributes_json')) {
            $data['attributes'] = json_decode($request->attributes_json, true);
        }

        $entity->update($data);

        return redirect()->route('admin.wiki.index')->with('success', 'Otoritas data entitas berhasil disinkronisasi.');
    }

    public function delete(WikiEntity $entity)
    {
        $entity->delete();
        return back()->with('success', 'Entitas Wiki dihapus.');
    }

    /**
     * AJAX Endpoint: Auto-generate content via AI.
     */
    public function autoGenerate(Request $request, \App\Services\Seo\WikiAiService $aiService)
    {
        $name = $request->get('name');
        $context = $request->get('context', '');
        
        if (!$name) return response()->json(['error' => 'Nama diperlukan'], 400);

        try {
            $generated = $aiService->generate($name, $context);
            
            return response()->json([
                'description' => $generated['desc'],
                'attributes' => $generated['attrs'],
                'wikidata_id' => $generated['wikidata'] ?? ''
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Wiki AI Error: ' . $e->getMessage());
            return response()->json(['error' => 'Neural Network Disruption: ' . $e->getMessage()], 500);
        }
    }
}
