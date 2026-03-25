<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Page;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PageController extends \App\Http\Controllers\Controller
{
    public function __construct()
    {
        // Viewers can only view, not create/edit/delete
        $this->middleware(function ($request, $next) {
            if (auth()->user()->role === 'viewer' && in_array($request->route()->getActionMethod(), ['create', 'store', 'edit', 'update', 'destroy'])) {
                abort(403, 'Unauthorized. Viewers have read-only access.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $pages = Page::latest()->paginate(10);
        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'meta_description' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string',
            'page_type' => 'nullable|string',
            'display_location' => 'nullable|string',
            'published' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('pages', 'public');
            $validated['image'] = $path;
        }

        $validated['slug'] = Str::slug($validated['title']);
        $validated['published'] = $request->has('published');

        Page::create($validated);

        return redirect()->route('admin.pages.index')->with('success', 'Page created successfully');
    }

    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'meta_description' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string',
            'page_type' => 'nullable|string',
            'display_location' => 'nullable|string',
            'published' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($page->image && Storage::disk('public')->exists($page->image)) {
                Storage::disk('public')->delete($page->image);
            }
            
            // Store new image
            $path = $request->file('image')->store('pages', 'public');
            $validated['image'] = $path;
        }
        if($validated['title']=='About Us'){
            $validated['slug'] = 'about';
        }else{
            $validated['slug'] = Str::slug($validated['title']);
        }
        $validated['published'] = $request->has('published');
        $page->update($validated);

        return redirect()->route('admin.pages.index')->with('success', 'Page updated successfully');
    }

    public function destroy(Page $page)
    {
        // Delete image if it exists
        if ($page->image && Storage::disk('public')->exists($page->image)) {
            Storage::disk('public')->delete($page->image);
        }
        
        $page->delete();
        return redirect()->route('admin.pages.index')->with('success', 'Page deleted successfully');
    }
}
