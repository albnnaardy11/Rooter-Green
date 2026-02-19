<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\ServiceRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    protected $serviceRepo;

    public function __construct(ServiceRepositoryInterface $serviceRepo)
    {
        $this->serviceRepo = $serviceRepo;
    }

    public function index()
    {
        $services = $this->serviceRepo->paginate(10);
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'icon' => 'required',
            'description_short' => 'required',
            'description_full' => 'required',
            'price' => 'nullable|numeric',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($request->name);
        $validated['is_active'] = $request->has('is_active');

        $this->serviceRepo->create($validated);

        return redirect()->route('admin.services.index')->with('success', 'Service created successfully.');
    }

    public function edit($id)
    {
        $service = $this->serviceRepo->find($id);
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'icon' => 'required',
            'description_short' => 'required',
            'description_full' => 'required',
            'price' => 'nullable|numeric',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($request->name);
        $validated['is_active'] = $request->has('is_active');

        $this->serviceRepo->update($id, $validated);

        return redirect()->route('admin.services.index')->with('success', 'Service updated successfully.');
    }

    public function destroy($id)
    {
        $this->serviceRepo->delete($id);
        return redirect()->route('admin.services.index')->with('success', 'Service deleted successfully.');
    }
}
