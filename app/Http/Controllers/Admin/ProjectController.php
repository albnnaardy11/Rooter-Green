<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\ProjectRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    protected $projectRepo;

    public function __construct(ProjectRepositoryInterface $projectRepo)
    {
        $this->projectRepo = $projectRepo;
    }

    public function index()
    {
        $projects = $this->projectRepo->paginate(10);
        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        return view('admin.projects.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'category' => 'required',
            'location' => 'nullable',
            'image' => 'required|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('projects', 'public');
            $validated['images'] = ['/storage/' . $path];
        }

        unset($validated['image']);
        $this->projectRepo->create($validated);

        return redirect()->route('admin.projects.index')->with('success', 'Project created successfully.');
    }

    public function edit($id)
    {
        $project = $this->projectRepo->find($id);
        $project->image_url = $project->images[0] ?? null;
        return view('admin.projects.edit', compact('project'));
    }

    public function update(Request $request, $id)
    {
        $project = $this->projectRepo->find($id);
        
        $validated = $request->validate([
            'title' => 'required|max:255',
            'category' => 'required',
            'location' => 'nullable',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            $oldImages = $project->images;
            if ($oldImages && isset($oldImages[0]) && strpos($oldImages[0], '/storage/') === 0) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $oldImages[0]));
            }
            $path = $request->file('image')->store('projects', 'public');
            $validated['images'] = ['/storage/' . $path];
        }

        unset($validated['image']);
        $this->projectRepo->update($id, $validated);

        return redirect()->route('admin.projects.index')->with('success', 'Project updated successfully.');
    }

    public function destroy($id)
    {
        $project = $this->projectRepo->find($id);
        $oldImages = $project->images;
        if ($oldImages) {
            foreach ($oldImages as $img) {
                if (strpos($img, '/storage/') === 0) {
                    Storage::disk('public')->delete(str_replace('/storage/', '', $img));
                }
            }
        }
        $this->projectRepo->delete($id);

        return redirect()->route('admin.projects.index')->with('success', 'Project deleted successfully.');
    }
}
