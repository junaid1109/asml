<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\TeamMember;

class TeamMemberController extends \App\Http\Controllers\Controller
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
        $teamMembers = TeamMember::orderBy('order')->paginate(10);
        return view('admin.team.index', compact('teamMembers'));
    }

    public function create()
    {
        return view('admin.team.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'twitter' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'facebook' => 'nullable|url',
            'instagram' => 'nullable|url',
            'published' => 'boolean',
            'order' => 'nullable|integer',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('team', 'public');
            $validated['image'] = $path;
        }

        $validated['published'] = $request->has('published');

        TeamMember::create($validated);

        return redirect()->route('admin.team.index')->with('success', 'Team member created successfully');
    }

    public function edit(TeamMember $team)
    {
        return view('admin.team.edit', compact('team'));
    }

    public function update(Request $request, TeamMember $team)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'twitter' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'facebook' => 'nullable|url',
            'instagram' => 'nullable|url',
            'published' => 'boolean',
            'order' => 'nullable|integer',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('team', 'public');
            $validated['image'] = $path;
        }

        $validated['published'] = $request->has('published');

        $team->update($validated);

        return redirect()->route('admin.team.index')->with('success', 'Team member updated successfully');
    }

    public function destroy(TeamMember $team)
    {
        $team->delete();
        return redirect()->route('admin.team.index')->with('success', 'Team member deleted successfully');
    }
}
