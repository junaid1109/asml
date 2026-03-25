<?php

namespace App\Http\Controllers\Admin;

use App\Models\Portfolio;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PortfolioAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (auth()->user()->role === 'viewer' && in_array($request->route()->getActionMethod(), ['create', 'store', 'edit', 'update', 'destroy'])) {
                abort(403, 'Unauthorized. Viewers have read-only access.');
            }
            return $next($request);
        });
    }

    /**
     * Display all portfolio items
     */
    public function index()
    {
        $portfolios = Portfolio::orderBy('display_order')->get();
        return view('admin.portfolios.index', compact('portfolios'));
    }

    /**
     * Show form to create new portfolio item
     */
    public function create()
    {
        return view('admin.portfolios.create');
    }

    /**
     * Store new portfolio item
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'link' => 'nullable|url',
            'icon' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
            'display_order' => 'nullable|integer',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('portfolios', 'public');
            $validated['image'] = $path;
        }

        $validated['is_active'] = $request->has('is_active');

        Portfolio::create($validated);

        return redirect()->route('admin.portfolios.index')
            ->with('success', 'Portfolio item created successfully.');
    }

    /**
     * Show form to edit portfolio item
     */
    public function edit(Portfolio $portfolio)
    {
        return view('admin.portfolios.edit', compact('portfolio'));
    }

    /**
     * Update portfolio item
     */
    public function update(Request $request, Portfolio $portfolio)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'link' => 'nullable|url',
            'icon' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
            'display_order' => 'nullable|integer',
        ]);

        if ($request->hasFile('image')) {
            if ($portfolio->image && \Storage::disk('public')->exists($portfolio->image)) {
                \Storage::disk('public')->delete($portfolio->image);
            }
            $path = $request->file('image')->store('portfolios', 'public');
            $validated['image'] = $path;
        }

        $validated['is_active'] = $request->has('is_active');

        $portfolio->update($validated);

        return redirect()->route('admin.portfolios.index')
            ->with('success', 'Portfolio item updated successfully.');
    }

    /**
     * Delete portfolio item
     */
    public function destroy(Portfolio $portfolio)
    {
        if ($portfolio->image && \Storage::disk('public')->exists($portfolio->image)) {
            \Storage::disk('public')->delete($portfolio->image);
        }
        $portfolio->delete();

        return redirect()->route('admin.portfolios.index')
            ->with('success', 'Portfolio item deleted successfully.');
    }
}
