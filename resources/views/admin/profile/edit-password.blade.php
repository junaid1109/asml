@extends('layouts.admin')

@section('page-title', 'Change Password')

@section('content')
<div style="padding: 20px; max-width: 600px;">
    <h2>Change Password</h2>

    <form action="{{ route('admin.profile.updatePassword') }}" method="POST" style="background: white; padding: 20px; border-radius: 5px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        @csrf

        <div style="margin-bottom: 20px;">
            <label for="current_password" style="display: block; margin-bottom: 8px; font-weight: 500;">Current Password <span style="color: #dc3545;">*</span></label>
            <input 
                type="password" 
                id="current_password" 
                name="current_password" 
                required
                style="width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 4px; box-sizing: border-box; @error('current_password') border-color: #dc3545; @enderror"
            >
            @error('current_password')
            <span style="color: #dc3545; font-size: 12px;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label for="password" style="display: block; margin-bottom: 8px; font-weight: 500;">New Password <span style="color: #dc3545;">*</span></label>
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
            <label for="password_confirmation" style="display: block; margin-bottom: 8px; font-weight: 500;">Confirm New Password <span style="color: #dc3545;">*</span></label>
            <input 
                type="password" 
                id="password_confirmation" 
                name="password_confirmation" 
                required
                style="width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 4px; box-sizing: border-box;"
            >
        </div>

        <div style="background-color: #e7f3ff; padding: 15px; border-radius: 4px; border-left: 4px solid #0dcaf0; margin-bottom: 20px;">
            <h5 style="margin-top: 0; margin-bottom: 10px; color: #0056b3;">Password Requirements</h5>
            <ul style="margin: 0; padding-left: 20px; color: #0056b3;">
                <li>Minimum 8 characters</li>
                <li>Mix of uppercase and lowercase letters</li>
                <li>Include numbers and special characters</li>
            </ul>
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary" style="background-color: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">
                <i class="bi bi-check-circle"></i> Update Password
            </button>
            <a href="{{ route('admin.profile.show') }}" class="btn btn-secondary" style="background-color: #6c757d; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block;">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
