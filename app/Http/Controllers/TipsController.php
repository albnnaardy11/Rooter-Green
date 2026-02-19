<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\PostRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TipsController extends Controller
{
    protected $postRepo;

    public function __construct(PostRepositoryInterface $postRepo)
    {
        $this->postRepo = $postRepo;
    }

    public function index()
    {
        $posts = $this->postRepo->all()->where('status', 'published')->map(function($post) {
            return [
                'title' => $post->title,
                'slug' => $post->slug,
                'excerpt' => Str::limit(strip_tags($post->content), 150),
                'category' => $post->category,
                'readTime' => ceil(str_word_count(strip_tags($post->content)) / 200) . ' min read',
                'img' => $post->featured_image,
                'date' => $post->created_at->format('d M Y'),
                'featured' => (bool)$post->is_featured,
            ];
        });
        
        return view('tips', compact('posts'));
    }

    public function show($slug)
    {
        $post = $this->postRepo->findBySlug($slug);
        return view('tips-detail', compact('post'));
    }
}
