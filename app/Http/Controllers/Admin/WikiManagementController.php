<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WikiEntity;
use App\Services\Seo\WikiAiService;
use Illuminate\Http\Request;

class WikiManagementController extends Controller
{
    public function index()
    {
        $entities = WikiEntity::orderByDesc('created_at')->paginate(15);
        return view('admin.wiki.index', compact('entities'));
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

        return back()->with('success', 'Entitas Wiki berhasil ditambahkan ke database otoritas.');
    }

    public function delete(WikiEntity $entity)
    {
        $entity->delete();
        return back()->with('success', 'Entitas Wiki dihapus.');
    }

    /**
     * AJAX Endpoint: Auto-generate content via AI.
     */
    public function autoGenerate(Request $request, WikiAiService $aiService)
    {
        $name = $request->get('name');
        if (!$name) return response()->json(['error' => 'Nama diperlukan'], 400);

        $generated = $aiService->generate($name);

        return response()->json([
            'description' => $generated['desc'],
            'attributes' => $generated['attrs']
        ]);
    }
}
