<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->paginate(10);
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

        $validated['slug'] = \Illuminate\Support\Str::slug($request->title);
        
        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('posts', 'public');
            $validated['featured_image'] = '/storage/' . $path;
        }

        Post::create($validated);

        return redirect()->route('admin.posts.index')->with('success', 'Article created successfully.');
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('admin.posts.edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'required|max:255',
            'category' => 'required',
            'content' => 'required',
            'status' => 'required|in:draft,published',
            'featured_image' => 'nullable|image|max:2048',
        ]);

        $validated['slug'] = \Illuminate\Support\Str::slug($request->title);
        
        if ($request->hasFile('featured_image')) {
            // Delete old image if exists
            if ($post->featured_image && strpos($post->featured_image, '/storage/') === 0) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete(str_replace('/storage/', '', $post->featured_image));
            }
            $path = $request->file('featured_image')->store('posts', 'public');
            $validated['featured_image'] = '/storage/' . $path;
        }

        $post->update($validated);

        return redirect()->route('admin.posts.index')->with('success', 'Article updated successfully.');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if ($post->featured_image && strpos($post->featured_image, '/storage/') === 0) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete(str_replace('/storage/', '', $post->featured_image));
        }
        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Article deleted successfully.');
    }
}
