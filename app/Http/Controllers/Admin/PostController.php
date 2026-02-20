<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\PostRepositoryInterface;
use App\Services\Image\ImageOptimizationService;
use App\Services\Seo\GoogleIndexingService;
use App\Services\Seo\SitemapService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    protected $postRepo;
    protected $imageService;
    protected $indexingService;
    protected $sitemapService;

    public function __construct(
        PostRepositoryInterface $postRepo,
        ImageOptimizationService $imageService,
        GoogleIndexingService $indexingService,
        SitemapService $sitemapService
    ) {
        $this->postRepo = $postRepo;
        $this->imageService = $imageService;
        $this->indexingService = $indexingService;
        $this->sitemapService = $sitemapService;
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
            'featured_image' => 'nullable|image|max:5120',
        ]);

        $validated['slug'] = Str::slug($request->title);
        
        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $this->imageService->optimize(
                $request->file('featured_image'), 
                'posts'
            );
        }

        $post = $this->postRepo->create($validated);

        if ($request->has('seo')) {
            $post->seo()->create($request->seo);
        }

        // SEO Automation
        if ($post->status === 'published') {
            $this->sitemapService->generate();
            $this->indexingService->notifyUpdate(url("/tips/{$post->slug}"));
        }

        return redirect()->route('admin.posts.index')->with('success', 'Article created and indexed successfully.');
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
            'featured_image' => 'nullable|image|max:5120',
        ]);

        $validated['slug'] = Str::slug($request->title);
        
        if ($request->hasFile('featured_image')) {
            // Delete old image if exists
            if ($post->featured_image && strpos($post->featured_image, '/storage/') === 0) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $post->featured_image));
            }
            $validated['featured_image'] = $this->imageService->optimize(
                $request->file('featured_image'), 
                'posts'
            );
        }

        $this->postRepo->update($id, $validated);

        if ($request->has('seo')) {
            $post->seo()->updateOrCreate([], $request->seo);
        }

        // SEO Automation
        if ($validated['status'] === 'published') {
            $this->sitemapService->generate();
            $this->indexingService->notifyUpdate(url("/tips/{$post->slug}"));
        }

        return redirect()->route('admin.posts.index')->with('success', 'Article updated and re-indexed.');
    }

    public function destroy($id)
    {
        $post = $this->postRepo->find($id);
        
        if ($post->featured_image && strpos($post->featured_image, '/storage/') === 0) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $post->featured_image));
        }
        
        $url = url("/tips/{$post->slug}");
        $this->postRepo->delete($id);

        // SEO Automation
        $this->sitemapService->generate();
        $this->indexingService->notifyUpdate($url, 'URL_DELETED');

        return redirect()->route('admin.posts.index')->with('success', 'Article deleted and removed from index.');
    }
}
