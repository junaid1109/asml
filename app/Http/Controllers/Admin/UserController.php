<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends \App\Http\Controllers\Controller
{
    public function __construct()
    {
        // Check if user is admin for all user management actions
        $this->middleware(function ($request, $next) {
            if (auth()->user()->role !== 'admin') {
                abort(403, 'Unauthorized. Only admins can manage users.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $users = User::paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,editor,viewer',
            'is_active' => 'boolean',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['is_active'] = $request->has('is_active');

        User::create($validated);

        return redirect()->route('admin.users.index')->with('success', 'Admin user created successfully.');
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => 'required|in:admin,editor,viewer',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', 'Admin user updated successfully.');
    }

    public function updatePassword(Request $request, User $user)
    {
        $validated = $request->validate([
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if (!empty($validated['password'])) {
            $user->update(['password' => Hash::make($validated['password'])]);
        }

        return redirect()->route('admin.users.edit', $user)->with('success', 'Password updated successfully.');
    }

    public function disable2FA(Request $request, User $user)
    {
        $user->update([
            'two_factor_enabled' => false,
            'two_factor_secret' => null,
            'two_factor_backup_codes' => null,
            'two_factor_confirmed_at' => null,
        ]);

        return redirect()->route('admin.users.edit', $user)->with('success', '2FA disabled successfully for this user.');
    }

    public function destroy(User $user)
    {
        // Prevent deleting the last admin
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')->with('error', 'Cannot delete your own account.');
        }

        if (User::where('role', 'admin')->count() <= 1 && $user->role === 'admin') {
            return redirect()->route('admin.users.index')->with('error', 'Cannot delete the last admin user.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Admin user deleted successfully.');
    }
}
