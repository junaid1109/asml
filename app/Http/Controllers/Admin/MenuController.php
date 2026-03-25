<?php

namespace App\Http\Controllers\Admin;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends \App\Http\Controllers\Controller
{
    public function index()
    {
        $menus = Menu::orderBy('order')->get();
        return view('admin.menus.index', compact('menus'));
    }

    public function create()
    {
        $routes = [
            'home' => 'Home',
            'about' => 'About',
            'team' => 'Team',
            'contact.index' => 'Contact',
            'portfolio.index' => 'Portfolio',
            'advisory.index' => 'Advisory',
        ];
        return view('admin.menus.create', compact('routes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'route_name' => 'nullable|string',
            'url' => 'nullable|url',
            'order' => 'required|integer',
            'active' => 'nullable|boolean',
        ]);

        if (!$validated['route_name'] && !$validated['url']) {
            return back()->withErrors(['error' => 'Route name or URL is required.']);
        }

        // Handle checkbox: if not checked, it won't be in request
        $validated['active'] = $request->has('active') ? true : false;

        Menu::create($validated);
        return redirect()->route('admin.menus.index')->with('success', 'Menu item created successfully.');
    }

    public function edit(Menu $menu)
    {
        $routes = [
            'home' => 'Home',
            'about' => 'About',
            'team' => 'Team',
            'contact.index' => 'Contact',
            'portfolio.index' => 'Portfolio',
            'advisory.index' => 'Advisory',
        ];
        return view('admin.menus.edit', compact('menu', 'routes'));
    }

    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'route_name' => 'nullable|string',
            'url' => 'nullable|url',
            'order' => 'required|integer',
            'active' => 'nullable|boolean',
        ]);

        if (!$validated['route_name'] && !$validated['url']) {
            return back()->withErrors(['error' => 'Route name or URL is required.']);
        }

        // Handle checkbox: if not checked, it won't be in request
        $validated['active'] = $request->has('active') ? true : false;

        $menu->update($validated);
        return redirect()->route('admin.menus.index')->with('success', 'Menu item updated successfully.');
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();
        return redirect()->route('admin.menus.index')->with('success', 'Menu item deleted successfully.');
    }

    public function reorder(Request $request)
    {
        $items = $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|integer',
            'items.*.order' => 'required|integer',
        ]);

        foreach ($request->items as $item) {
            Menu::find($item['id'])->update(['order' => $item['order']]);
        }

        return response()->json(['success' => true]);
    }
}
