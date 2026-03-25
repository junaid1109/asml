@extends('layouts.admin')

@section('page-title', 'Add New Admin User')

@section('content')
<div style="padding: 20px; max-width: 600px;">
    <h2>Add New Admin User</h2>

    <form action="{{ route('admin.users.store') }}" method="POST" style="background: white; padding: 20px; border-radius: 5px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        @csrf

        <div style="margin-bottom: 20px;">
            <label for="name" style="display: block; margin-bottom: 8px; font-weight: 500;">Name <span style="color: #dc3545;">*</span></label>
            <input 
                type="text" 
                id="name" 
                name="name" 
                value="{{ old('name') }}"
                required
                style="width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 4px; box-sizing: border-box; @error('name') border-color: #dc3545; @enderror"
            >
            @error('name')
            <span style="color: #dc3545; font-size: 12px;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label for="email" style="display: block; margin-bottom: 8px; font-weight: 500;">Email <span style="color: #dc3545;">*</span></label>
            <input 
                type="email" 
                id="email" 
                name="email" 
                value="{{ old('email') }}"
                required
                style="width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 4px; box-sizing: border-box; @error('email') border-color: #dc3545; @enderror"
            >
            @error('email')
            <span style="color: #dc3545; font-size: 12px;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label for="password" style="display: block; margin-bottom: 8px; font-weight: 500;">Password <span style="color: #dc3545;">*</span></label>
            <input 
                type="password" 
                id="password" 
                name="password" 
                required
                style="width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 4px; box-sizing: border-box; @error('password') border-color: #dc3545; @enderror"
            >
            <small style="color: #6c757d;">Minimum 8 characters</small>
            @error('password')
            <span style="color: #dc3545; font-size: 12px;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label for="password_confirmation" style="display: block; margin-bottom: 8px; font-weight: 500;">Confirm Password <span style="color: #dc3545;">*</span></label>
            <input 
                type="password" 
                id="password_confirmation" 
                name="password_confirmation" 
                required
                style="width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 4px; box-sizing: border-box;"
            >
        </div>

        <div style="margin-bottom: 20px;">
            <label for="role" style="display: block; margin-bottom: 8px; font-weight: 500;">Role <span style="color: #dc3545;">*</span></label>
            <select 
                id="role" 
                name="role" 
                required
                style="width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 4px; box-sizing: border-box; @error('role') border-color: #dc3545; @enderror"
            >
                <option value="">Select a role</option>
                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin (Full Access)</option>
                <option value="editor" {{ old('role') === 'editor' ? 'selected' : '' }}>Editor (Content Management)</option>
                <option value="viewer" {{ old('role') === 'viewer' ? 'selected' : '' }}>Viewer (Read Only)</option>
            </select>
            @error('role')
            <span style="color: #dc3545; font-size: 12px;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: flex; align-items: center;">
                <input 
                    type="checkbox" 
                    name="is_active" 
                    value="1"
                    {{ old('is_active', true) ? 'checked' : '' }}
                    style="margin-right: 10px;"
                >
                <span>Active User</span>
            </label>
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary" style="background-color: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">
                <i class="bi bi-plus-circle"></i> Create User
            </button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary" style="background-color: #6c757d; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block;">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
