<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends \App\Http\Controllers\Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        // Find the user by email
        $user = User::where('email', $validated['email'])->first();

        // Check if user exists and password is correct
        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        }

        // Check if user is active
        if (!$user->is_active) {
            return back()->withErrors([
                'email' => 'Your account has been disabled. Please contact an administrator.',
            ])->onlyInput('email');
        }

        // If 2FA is enabled, redirect to 2FA verification page
        if ($user->two_factor_enabled) {
            $request->session()->put('2fa_user_id', $user->id);
            return redirect()->route('login.2fa');
        }

        // Otherwise, complete the login normally
        Auth::login($user);
        $request->session()->regenerate();
        return redirect()->route('admin.dashboard');
    }

    public function show2FAForm()
    {
        // Check if user is in 2FA verification process
        if (!session()->has('2fa_user_id')) {
            return redirect()->route('login');
        }

        return view('auth.2fa-login');
    }

    public function verify2FA(Request $request)
    {
        // Check if user is in 2FA verification process
        if (!session()->has('2fa_user_id')) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'code' => 'required|string|size:6',
        ]);

        $user = User::find(session('2fa_user_id'));

        if (!$user || !$user->two_factor_enabled) {
            session()->forget('2fa_user_id');
            return back()->withErrors([
                'code' => 'Invalid 2FA verification process.',
            ]);
        }

        // Verify the 2FA code
        if (!$this->verifyCode($user->two_factor_secret, $validated['code'])) {
            return back()->withErrors([
                'code' => 'Invalid verification code. Please try again.',
            ])->onlyInput('code');
        }

        // Code is valid, complete the login
        Auth::login($user);
        $request->session()->regenerate();
        session()->forget('2fa_user_id');

        return redirect()->route('admin.dashboard');
    }

    // TOTP verification logic (same as ProfileController)
    private function verifyCode($secret, $code)
    {
        // TOTP verification using time-based OTP
        $secretBinary = $this->base32Decode($secret);
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

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
