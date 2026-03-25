@extends('layouts.admin')

@section('page-title', 'Manage Admin Users')

@section('content')
<div style="padding: 20px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>Admin Users</h2>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary" style="background-color: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
            <i class="bi bi-plus-circle"></i> Add New Admin
        </a>
    </div>

    @if ($errors->any())
    <div class="alert alert-danger" style="padding: 15px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 5px; margin-bottom: 20px;">
        <h4>Please fix the following errors:</h4>
        <ul style="margin: 10px 0 0 0;">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <table style="width: 100%; border-collapse: collapse; background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        <thead>
            <tr style="background-color: #f8f9fa; border-bottom: 2px solid #dee2e6;">
                <th style="padding: 15px; text-align: left; border-right: 1px solid #dee2e6;">Name</th>
                <th style="padding: 15px; text-align: left; border-right: 1px solid #dee2e6;">Email</th>
                <th style="padding: 15px; text-align: left; border-right: 1px solid #dee2e6;">Role</th>
                <th style="padding: 15px; text-align: left; border-right: 1px solid #dee2e6;">2FA</th>
                <th style="padding: 15px; text-align: left; border-right: 1px solid #dee2e6;">Status</th>
                <th style="padding: 15px; text-align: center;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
            <tr style="border-bottom: 1px solid #dee2e6;">
                <td style="padding: 15px; border-right: 1px solid #dee2e6;">{{ $user->name }}</td>
                <td style="padding: 15px; border-right: 1px solid #dee2e6;">{{ $user->email }}</td>
                <td style="padding: 15px; border-right: 1px solid #dee2e6;">
                    <span style="background-color: #e2e3e5; padding: 5px 10px; border-radius: 3px; font-size: 12px; text-transform: uppercase;">
                        {{ ucfirst($user->role) }}
                    </span>
                </td>
                <td style="padding: 15px; border-right: 1px solid #dee2e6;">
                    @if ($user->isTwoFactorEnabled())
                    <span style="background-color: #d4edda; color: #155724; padding: 5px 10px; border-radius: 3px; font-size: 12px;">
                        <i class="bi bi-check-circle"></i> Enabled
                    </span>
                    @else
                    <span style="background-color: #f8d7da; color: #721c24; padding: 5px 10px; border-radius: 3px; font-size: 12px;">
                        <i class="bi bi-x-circle"></i> Disabled
                    </span>
                    @endif
                </td>
                <td style="padding: 15px; border-right: 1px solid #dee2e6;">
                    @if ($user->is_active)
                    <span style="background-color: #d4edda; color: #155724; padding: 5px 10px; border-radius: 3px; font-size: 12px;">
                        Active
                    </span>
                    @else
                    <span style="background-color: #f8d7da; color: #721c24; padding: 5px 10px; border-radius: 3px; font-size: 12px;">
                        Inactive
                    </span>
                    @endif
                </td>
                <td style="padding: 15px; text-align: center;">
                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm" style="background-color: #28a745; color: white; padding: 5px 10px; text-decoration: none; border-radius: 3px; margin-right: 5px; display: inline-block;">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm" style="background-color: #dc3545; color: white; padding: 5px 10px; border: none; border-radius: 3px; cursor: pointer;" onclick="return confirm('Are you sure?')">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="padding: 20px; text-align: center; color: #999;">No admin users found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        {{ $users->links() }}
    </div>
</div>
@endsection
