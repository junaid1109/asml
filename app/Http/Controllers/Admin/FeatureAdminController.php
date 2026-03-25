<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FeatureAdminController extends Controller
{
    public function index()
    {
        $features = Feature::orderBy('display_order')->get();
        return view('admin.features.index', compact('features'));
    }

    public function create()
    {
        return view('admin.features.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon_file' => 'nullable|image|mimes:jpeg,png,gif,webp|max:2048',
            'display_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean'
        ]);

        // Handle file upload
        if ($request->hasFile('icon_file')) {
            $validated['icon_file'] = $request->file('icon_file')->store('features', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        Feature::create($validated);

        return redirect()->route('admin.features.index')->with('success', 'Feature created successfully');
    }

    public function edit(Feature $feature)
    {
        return view('admin.features.edit', compact('feature'));
    }

    public function update(Request $request, Feature $feature)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon_file' => 'nullable|image|mimes:jpeg,png,gif,webp|max:2048',
            'display_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean'
        ]);

        // Handle file upload
        if ($request->hasFile('icon_file')) {
            // Delete old file
            if ($feature->icon_file) {
                Storage::disk('public')->delete($feature->icon_file);
            }
            $validated['icon_file'] = $request->file('icon_file')->store('features', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        $feature->update($validated);

        return redirect()->route('admin.features.index')->with('success', 'Feature updated successfully');
    }

    public function destroy(Feature $feature)
    {
        if ($feature->icon_file) {
            Storage::disk('public')->delete($feature->icon_file);
        }
        $feature->delete();

        return redirect()->route('admin.features.index')->with('success', 'Feature deleted successfully');
    }
}
