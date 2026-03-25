@extends('layouts.admin')

@section('page-title', 'My Profile')

@section('content')
<div style="padding: 20px;">
    <h2>My Profile</h2>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        <!-- Profile Information -->
        <div style="background: white; padding: 20px; border-radius: 5px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <h3 style="margin-top: 0;">Account Information</h3>
            
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 500; color: #666; margin-bottom: 5px;">Name</label>
                <p style="margin: 0; padding: 10px; background-color: #f8f9fa; border-radius: 4px;">{{ $user->name }}</p>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 500; color: #666; margin-bottom: 5px;">Email</label>
                <p style="margin: 0; padding: 10px; background-color: #f8f9fa; border-radius: 4px;">{{ $user->email }}</p>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 500; color: #666; margin-bottom: 5px;">Role</label>
                <p style="margin: 0; padding: 10px; background-color: #f8f9fa; border-radius: 4px;">
                    <span style="background-color: #e2e3e5; padding: 5px 10px; border-radius: 3px; font-size: 12px; text-transform: uppercase;">
                        {{ ucfirst($user->role) }}
                    </span>
                </p>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 500; color: #666; margin-bottom: 5px;">Account Status</label>
                <p style="margin: 0; padding: 10px; background-color: #f8f9fa; border-radius: 4px;">
                    @if ($user->is_active)
                    <span style="background-color: #d4edda; color: #155724; padding: 5px 10px; border-radius: 3px; font-size: 12px;">
                        <i class="bi bi-check-circle"></i> Active
                    </span>
                    @else
                    <span style="background-color: #f8d7da; color: #721c24; padding: 5px 10px; border-radius: 3px; font-size: 12px;">
                        <i class="bi bi-x-circle"></i> Inactive
                    </span>
                    @endif
                </p>
            </div>

            <a href="{{ route('admin.profile.editPassword') }}" class="btn btn-primary" style="background-color: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block;">
                <i class="bi bi-lock"></i> Change Password
            </a>
        </div>

        <!-- Security Settings -->
        <div style="background: white; padding: 20px; border-radius: 5px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <h3 style="margin-top: 0;">Security Settings</h3>
            
            <div style="margin-bottom: 20px; padding: 15px; background-color: #f8f9fa; border-radius: 4px; border-left: 4px solid #0dcaf0;">
                <h5 style="margin-top: 0; margin-bottom: 10px;">Two-Factor Authentication (2FA)</h5>
                
                @if ($user->isTwoFactorEnabled())
                <p style="margin: 0 0 15px 0; color: #155724; background-color: #d4edda; padding: 10px; border-radius: 4px;">
                    <i class="bi bi-shield-check"></i> <strong>2FA is enabled</strong>
                </p>
                
                <form method="POST" action="{{ route('admin.profile.disable2FA') }}" style="margin: 0;">
                    @csrf
                    
                    <div style="margin-bottom: 15px;">
                        <label for="password" style="display: block; margin-bottom: 8px; font-weight: 500;">Enter your password to disable 2FA</label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            required
                            placeholder="Enter your password"
                            style="width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 4px; box-sizing: border-box; margin-bottom: 10px;"
                        >
                    </div>

                    <button type="submit" class="btn btn-danger" style="background-color: #dc3545; color: white; padding: 8px 16px; border: none; border-radius: 5px; cursor: pointer;" onclick="return confirm('Are you sure? You will need to set up 2FA again to re-enable it.')">
                        <i class="bi bi-shield-x"></i> Disable 2FA
                    </button>
                </form>
                @else
                <p style="margin: 0 0 15px 0; color: #721c24; background-color: #f8d7da; padding: 10px; border-radius: 4px;">
                    <i class="bi bi-shield-exclamation"></i> <strong>2FA is not enabled</strong>
                </p>
                
                <p style="margin: 0 0 15px 0; color: #666;">Add an extra layer of security to your account by enabling Two-Factor Authentication.</p>
                
                <a href="{{ route('admin.profile.setup2FA') }}" class="btn btn-success" style="background-color: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block;">
                    <i class="bi bi-plus-circle"></i> Enable 2FA
                </a>
                @endif
            </div>
        </div>
    </div>
</div>

@if (session('show_backup_codes'))
<div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; z-index: 999;">
    <div style="background: white; padding: 30px; border-radius: 8px; max-width: 500px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <h3 style="margin-top: 0; color: #dc3545;">⚠️ Save Your Backup Codes</h3>
        <p style="color: #666;">Save these backup codes in a safe place. You can use them to access your account if you lose access to your 2FA device.</p>
        
        <div style="background-color: #f8f9fa; padding: 15px; border-radius: 4px; margin: 20px 0; font-family: monospace; white-space: pre-wrap; word-wrap: break-word;">
            @foreach (session('backup_codes') as $code)
{{ $code }}
            @endforeach
        </div>

        <p style="color: #721c24; background-color: #f8d7da; padding: 10px; border-radius: 4px; margin: 20px 0;">
            <strong>Important:</strong> Never share these codes with anyone. Store them securely.
        </p>

        <form action="{{ route('admin.profile.show') }}" method="GET">
            <button type="submit" class="btn btn-primary" style="background-color: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; width: 100%;">
                <i class="bi bi-check-circle"></i> I've Saved My Backup Codes
            </button>
        </form>
    </div>
</div>
@endif

@endsection
