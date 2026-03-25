<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutParagraph;
use Illuminate\Http\Request;

class AboutParagraphAdminController extends Controller
{
    public function index()
    {
        $paragraphs = AboutParagraph::ordered()->get();
        return view('admin.about-paragraphs.index', compact('paragraphs'));
    }

    public function create()
    {
        return view('admin.about-paragraphs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'details' => 'required|string',
            'display_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');

        AboutParagraph::create($validated);

        return redirect()->route('admin.about-paragraphs.index')->with('success', 'About paragraph created successfully');
    }

    public function edit(AboutParagraph $aboutParagraph)
    {
        return view('admin.about-paragraphs.edit', compact('aboutParagraph'));
    }

    public function update(Request $request, AboutParagraph $aboutParagraph)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'details' => 'required|string',
            'display_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');

        $aboutParagraph->update($validated);

        return redirect()->route('admin.about-paragraphs.index')->with('success', 'About paragraph updated successfully');
    }

    public function destroy(AboutParagraph $aboutParagraph)
    {
        $aboutParagraph->delete();

        return redirect()->route('admin.about-paragraphs.index')->with('success', 'About paragraph deleted successfully');
    }
}
