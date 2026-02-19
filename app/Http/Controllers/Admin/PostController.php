<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\PostRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    protected $postRepo;

    public function __construct(PostRepositoryInterface $postRepo)
    {
        $this->postRepo = $postRepo;
    }

    public function index()
    {
        $posts = $this->postRepo->paginate(10);
        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.posts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'category' => 'required',
            'content' => 'required',
            'status' => 'required|in:draft,published',
            'featured_image' => 'nullable|image|max:2048',
        ]);

        $validated['slug'] = Str::slug($request->title);
        
        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('posts', 'public');
            $validated['featured_image'] = '/storage/' . $path;
        }

        $post = $this->postRepo->create($validated);

        if ($request->has('seo')) {
            $post->seo()->create($request->seo);
        }

        return redirect()->route('admin.posts.index')->with('success', 'Article created successfully.');
    }

    public function edit($id)
    {
        $post = $this->postRepo->find($id);
        return view('admin.posts.edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $post = $this->postRepo->find($id);
        
        $validated = $request->validate([
            'title' => 'required|max:255',
            'category' => 'required',
            'content' => 'required',
            'status' => 'required|in:draft,published',
            'featured_image' => 'nullable|image|max:2048',
        ]);

        $validated['slug'] = Str::slug($request->title);
        
        if ($request->hasFile('featured_image')) {
            if ($post->featured_image && strpos($post->featured_image, '/storage/') === 0) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $post->featured_image));
            }
            $path = $request->file('featured_image')->store('posts', 'public');
            $validated['featured_image'] = '/storage/' . $path;
        }

        $this->postRepo->update($id, $validated);

        if ($request->has('seo')) {
            $post->seo()->updateOrCreate([], $request->seo);
        }

        return redirect()->route('admin.posts.index')->with('success', 'Article updated successfully.');
    }

    public function destroy($id)
    {
        $post = $this->postRepo->find($id);
        if ($post->featured_image && strpos($post->featured_image, '/storage/') === 0) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $post->featured_image));
        }
        $this->postRepo->delete($id);

        return redirect()->route('admin.posts.index')->with('success', 'Article deleted successfully.');
    }
}
