@extends('layouts.admin')

@section('page-title', 'Edit Admin User')

@section('content')
<div style="padding: 20px; max-width: 900px;">
    <h2>Edit Admin User</h2>

    <!-- Tabs Navigation -->
    <ul class="nav nav-tabs" role="tablist" style="margin-bottom: 20px; border-bottom: 2px solid #dee2e6;">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="basic-info-tab" data-bs-toggle="tab" data-bs-target="#basic-info" type="button" role="tab">
                <i class="bi bi-person"></i> Basic Information
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="password-tab" data-bs-toggle="tab" data-bs-target="#password" type="button" role="tab">
                <i class="bi bi-lock"></i> Change Password
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="2fa-tab" data-bs-toggle="tab" data-bs-target="#2fa" type="button" role="tab">
                <i class="bi bi-shield-check"></i> 2FA Management
            </button>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content">
        <!-- Basic Information Tab -->
        <div class="tab-pane fade show active" id="basic-info" role="tabpanel">
            <form action="{{ route('admin.users.update', $user) }}" method="POST" style="background: white; padding: 20px; border-radius: 5px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                @csrf
                @method('PUT')

                <div style="margin-bottom: 20px;">
                    <label for="name" style="display: block; margin-bottom: 8px; font-weight: 500;">Name <span style="color: #dc3545;">*</span></label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name', $user->name) }}"
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
                        value="{{ old('email', $user->email) }}"
                        required
                        style="width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 4px; box-sizing: border-box; @error('email') border-color: #dc3545; @enderror"
                    >
                    @error('email')
                    <span style="color: #dc3545; font-size: 12px;">{{ $message }}</span>
                    @enderror
                </div>

                <div style="margin-bottom: 20px;">
                    <label for="role" style="display: block; margin-bottom: 8px; font-weight: 500;">Role <span style="color: #dc3545;">*</span></label>
                    <select 
                        id="role" 
                        name="role" 
                        required
                        style="width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 4px; box-sizing: border-box; @error('role') border-color: #dc3545; @enderror"
                    >
                        <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin (Full Access)</option>
                        <option value="editor" {{ old('role', $user->role) === 'editor' ? 'selected' : '' }}>Editor (Content Management)</option>
                        <option value="viewer" {{ old('role', $user->role) === 'viewer' ? 'selected' : '' }}>Viewer (Read Only)</option>
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
                            {{ old('is_active', $user->is_active) ? 'checked' : '' }}
                            style="margin-right: 10px;"
                        >
                        <span>Active User</span>
                    </label>
                </div>

                <div style="display: flex; gap: 10px;">
                    <button type="submit" class="btn btn-primary" style="background-color: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">
                        <i class="bi bi-check-circle"></i> Update User
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary" style="background-color: #6c757d; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block;">
                        Cancel
                    </a>
                </div>
            </form>
        </div>

        <!-- Change Password Tab -->
        <div class="tab-pane fade" id="password" role="tabpanel">
            <form action="{{ route('admin.users.updatePassword', $user) }}" method="POST" style="background: white; padding: 20px; border-radius: 5px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                @csrf
                @method('PUT')

                <div style="margin-bottom: 15px; padding: 12px; background-color: #e7f3ff; border-left: 4px solid #007bff; border-radius: 4px;">
                    <p style="margin: 0; font-size: 14px; color: #004085;">
                        <i class="bi bi-info-circle"></i> Set a new password for this user. You can leave blank if not changing password.
                    </p>
                </div>

                <div style="margin-bottom: 20px;">
                    <label for="password" style="display: block; margin-bottom: 8px; font-weight: 500;">New Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password"
                        placeholder="Leave blank to keep current password"
                        style="width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 4px; box-sizing: border-box; @error('password') border-color: #dc3545; @enderror"
                    >
                    @error('password')
                    <span style="color: #dc3545; font-size: 12px;">{{ $message }}</span>
                    @enderror
                    <small style="color: #666; display: block; margin-top: 5px;">
                        ✓ Minimum 8 characters | ✓ Mix of uppercase & lowercase | ✓ At least one number | ✓ At least one special character
                    </small>
                </div>

                <div style="margin-bottom: 20px;">
                    <label for="password_confirmation" style="display: block; margin-bottom: 8px; font-weight: 500;">Confirm Password</label>
                    <input 
                        type="password" 
                        id="password_confirmation" 
                        name="password_confirmation"
                        placeholder="Repeat the password"
                        style="width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 4px; box-sizing: border-box;"
                    >
                </div>

                <div style="display: flex; gap: 10px;">
                    <button type="submit" class="btn btn-success" style="background-color: #28a745; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">
                        <i class="bi bi-check2"></i> Set Password
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary" style="background-color: #6c757d; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block;">
                        Cancel
                    </a>
                </div>
            </form>
        </div>

        <!-- 2FA Management Tab -->
        <div class="tab-pane fade" id="2fa" role="tabpanel">
            <div style="background: white; padding: 20px; border-radius: 5px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <h5 style="margin-bottom: 20px;">Two-Factor Authentication (2FA)</h5>

                <div style="margin-bottom: 20px;">
                    <div style="padding: 15px; border-radius: 4px; margin-bottom: 20px; @if($user->isTwoFactorEnabled()) background-color: #d4edda; border-left: 4px solid #28a745; @else background-color: #f8d7da; border-left: 4px solid #dc3545; @endif">
                        <p style="margin: 0; font-weight: 500;">
                            @if($user->isTwoFactorEnabled())
                                <i class="bi bi-check-circle" style="color: #155724;"></i> <span style="color: #155724;">2FA is <strong>ENABLED</strong> for this user</span>
                                <br><small style="color: #155724; margin-top: 5px; display: block;">Last confirmed: {{ $user->two_factor_confirmed_at?->format('M d, Y H:i') ?? 'Never' }}</small>
                            @else
                                <i class="bi bi-x-circle" style="color: #721c24;"></i> <span style="color: #721c24;">2FA is <strong>DISABLED</strong> for this user</span>
                            @endif
                        </p>
                    </div>
                </div>

                @if($user->isTwoFactorEnabled())
                <div style="margin-bottom: 20px;">
                    <h6 style="margin-bottom: 15px; color: #dc3545;">Disable 2FA for This User</h6>
                    <form action="{{ route('admin.users.disable2FA', $user) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-danger" style="background-color: #dc3545; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;" onclick="return confirm('Are you sure you want to disable 2FA for this user?');">
                            <i class="bi bi-shield-x"></i> Disable 2FA
                        </button>
                    </form>
                </div>

                <hr style="margin: 20px 0;">

                <div style="margin-bottom: 20px;">
                    <h6 style="margin-bottom: 15px;">View Backup Codes</h6>
                    <p style="font-size: 12px; color: #666; margin-bottom: 10px;">These codes were generated when 2FA was enabled. Each code can be used once for recovery.</p>
                    @if($user->two_factor_backup_codes)
                        @php
                            $codes = json_decode($user->two_factor_backup_codes, true) ?? [];
                        @endphp
                        @if(!empty($codes))
                            <div style="background-color: #f8f9fa; padding: 15px; border-radius: 4px; font-family: monospace; font-size: 13px; line-height: 1.8;">
                                @foreach($codes as $code)
                                    <code style="display: block; padding: 3px 0; color: #333;">{{ $code }}</code>
                                @endforeach
                            </div>
                        @else
                            <p style="color: #666; font-size: 13px;">No backup codes available</p>
                        @endif
                    @else
                        <p style="color: #666; font-size: 13px;">No backup codes stored</p>
                    @endif
                </div>
                @else
                <div style="margin-bottom: 20px; padding: 15px; background-color: #fff3cd; border-left: 4px solid #ffc107; border-radius: 4px;">
                    <p style="margin: 0; color: #856404;">
                        <i class="bi bi-exclamation-triangle"></i> The user must enable 2FA themselves from their profile page. Admin cannot enable 2FA for users.
                    </p>
                </div>

                <div style="padding: 15px; background-color: #e7f3ff; border-left: 4px solid #007bff; border-radius: 4px;">
                    <h6 style="margin-top: 0; margin-bottom: 10px; color: #004085;">How 2FA Works:</h6>
                    <ol style="color: #004085; margin: 0; padding-left: 20px;">
                        <li>User goes to <strong>My Profile → Enable 2FA</strong></li>
                        <li>They scan a QR code with an authenticator app (Google Authenticator, Microsoft Authenticator, Authy, etc.)</li>
                        <li>They enter the 6-digit code from their app</li>
                        <li>10 backup codes are generated and displayed</li>
                        <li>They must save these codes in a safe place</li>
                        <li>2FA is now enabled and required for future logins</li>
                    </ol>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
@endsection
