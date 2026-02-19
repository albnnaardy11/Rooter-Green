<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function index()
    {
        $files = Media::latest()->paginate(24);
        return view('admin.media.index', compact('files'));
    }

    public function store(Request $request)
    {
        $request->validate(['file' => 'required|image|max:5120']);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('uploads', 'public');

            Media::create([
                'filename' => basename($path),
                'original_name' => $file->getClientOriginalName(),
                'mime_type' => $file->getMimeType(),
                'size' => $file->getSize(),
                'path' => $path,
                'disk' => 'public',
            ]);
        }

        return back()->with('success', 'File uploaded to library.');
    }

    public function destroy($id)
    {
        $media = Media::findOrFail($id);
        Storage::disk($media->disk)->delete($media->path);
        $media->delete();

        return back()->with('success', 'File removed from library.');
    }
}
