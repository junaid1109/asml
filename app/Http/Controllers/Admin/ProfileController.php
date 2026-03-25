<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends \App\Http\Controllers\Controller
{
    public function show()
    {
        $user = auth()->user();
        return view('admin.profile.show', compact('user'));
    }

    public function editPassword()
    {
        return view('admin.profile.edit-password');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->with('error', 'Current password is incorrect.');
        }

        $user->update(['password' => Hash::make($validated['password'])]);

        return redirect()->route('admin.profile.show')->with('success', 'Password updated successfully.');
    }

    public function setup2FA()
    {
        $user = auth()->user();

        if ($user->two_factor_enabled) {
            return redirect()->route('admin.profile.show')->with('info', '2FA is already enabled.');
        }

        // Generate a random secret for 2FA
        $secret = $this->generateSecret();

        return view('admin.profile.setup-2fa', [
            'secret' => $secret,
            'qrCode' => $this->getQRCode($user->email, $secret),
        ]);
    }

    public function enable2FA(Request $request)
    {
        $validated = $request->validate([
            'secret' => 'required|string',
            'code' => 'required|string|size:6',
        ]);

        $user = auth()->user();

        // Verify the code
        if (!$this->verifyCode($validated['secret'], $validated['code'])) {
            return back()->with('error', 'Invalid verification code. Please try again.');
        }

        // Generate backup codes
        $backupCodes = $this->generateBackupCodes();

        $user->update([
            'two_factor_enabled' => true,
            'two_factor_secret' => $validated['secret'],
            'two_factor_backup_codes' => json_encode($backupCodes),
            'two_factor_confirmed_at' => now(),
        ]);

        session(['show_backup_codes' => true, 'backup_codes' => $backupCodes]);

        return redirect()->route('admin.profile.show')->with('success', '2FA enabled successfully. Please save your backup codes.');
    }

    public function disable2FA(Request $request)
    {
        $validated = $request->validate([
            'password' => 'required|string',
        ]);

        $user = auth()->user();

        if (!Hash::check($validated['password'], $user->password)) {
            return back()->with('error', 'Password is incorrect.');
        }

        $user->update([
            'two_factor_enabled' => false,
            'two_factor_secret' => null,
            'two_factor_backup_codes' => null,
            'two_factor_confirmed_at' => null,
        ]);

        return redirect()->route('admin.profile.show')->with('success', '2FA disabled successfully.');
    }

    // Helper methods
    private function generateSecret()
    {
        // Generate 32 random bytes (256 bits) - proper way for TOTP
        $randomBytes = random_bytes(32);
        // Base32 encode the random bytes
        return $this->base32Encode($randomBytes);
    }

    private function generateBackupCodes()
    {
        $codes = [];
        for ($i = 0; $i < 10; $i++) {
            $codes[] = strtoupper(bin2hex(random_bytes(4)));
        }
        return $codes;
    }

    private function getQRCode($email, $secret)
    {
        $appName = config('app.name', 'AMS');
        $data = "otpauth://totp/" . urlencode($email) . "?secret=" . $secret . "&issuer=" . urlencode($appName);
        return "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=" . urlencode($data);
    }

    private function verifyCode($secret, $code)
    {
        // TOTP verification using time-based OTP
        // This is a simplified implementation that works with standard TOTP apps
        
        // Convert base32 secret to binary
        $secretBinary = $this->base32Decode($secret);
        
        // Check current time and nearby time windows (current, -30s, -60s, +30s, +60s)
        $time = floor(time() / 30);
        
        for ($i = -2; $i <= 2; $i++) {
            $hmac = hash_hmac('sha1', pack('N*', 0) . pack('N', $time + $i), $secretBinary, true);
            $offset = ord($hmac[strlen($hmac) - 1]) & 0xf;
            $otp = (((ord($hmac[$offset]) & 0x7f) << 24) |
                    ((ord($hmac[$offset + 1]) & 0xff) << 16) |
                    ((ord($hmac[$offset + 2]) & 0xff) << 8) |
                    (ord($hmac[$offset + 3]) & 0xff)) % 1000000;
            
            if (str_pad($otp, 6, '0', STR_PAD_LEFT) === str_pad($code, 6, '0', STR_PAD_LEFT)) {
                return true;
            }
        }
        
        return false;
    }
    
    private function base32Decode($input)
    {
        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
        $output = '';
        $v = 0;
        $vbits = 0;
        
        $input = strtoupper($input);
        
        for ($i = 0; $i < strlen($input); $i++) {
            $c = strpos($alphabet, $input[$i]);
            if ($c === false) continue;
            
            $v = ($v << 5) | $c;
            $vbits += 5;
            
            while ($vbits >= 8) {
                $vbits -= 8;
                $output .= chr(($v >> $vbits) & 0xff);
            }
        }
        
        return $output;
    }

    private function base32Encode($input)
    {
        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
        $output = '';
        $v = 0;
        $vbits = 0;

        for ($i = 0; $i < strlen($input); $i++) {
            $v = ($v << 8) | ord($input[$i]);
            $vbits += 8;

            while ($vbits >= 5) {
                $vbits -= 5;
                $output .= $alphabet[($v >> $vbits) & 0x1F];
            }
        }

        if ($vbits > 0) {
            $output .= $alphabet[($v << (5 - $vbits)) & 0x1F];
        }

        // Add padding
        while (strlen($output) % 8 != 0) {
            $output .= '=';
        }

        return $output;
    }
}
