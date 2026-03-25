<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Helpers\SettingHelper;

class SettingController extends \App\Http\Controllers\Controller
{
    public function __construct()
    {
        // Settings can only be accessed by admins
        $this->middleware(function ($request, $next) {
            if (auth()->user()->role !== 'admin') {
                abort(403, 'Unauthorized. Only admins can modify settings.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'nullable|string|max:255',
            'site_email' => 'nullable|email',
            'site_phone' => 'nullable|string',
            'site_fax' => 'nullable|string',
            'site_address' => 'nullable|string',
            'site_description' => 'nullable|string',
            'footer_description' => 'nullable|string',
            'demo_video_url' => 'nullable|url',
            'demo_video_file' => 'nullable|file|mimes:mp4,webm,ogg,mov,avi|max:102400',
            'site_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'site_favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,ico|max:1024',
            'site_tagline' => 'nullable|string|max:255',
            'facebook_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'linkedin_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'hero_cta_button_enabled' => 'nullable|boolean',
            'demo_video_button_enabled' => 'nullable|boolean',
        ]);

        // Handle logo upload
        if ($request->hasFile('site_logo')) {
            $path = $request->file('site_logo')->store('settings', 'public');
            $validated['site_logo'] = $path;
        }

        // Handle favicon upload
        if ($request->hasFile('site_favicon')) {
            $path = $request->file('site_favicon')->store('settings', 'public');
            $validated['site_favicon'] = $path;
        }

        // Handle video file upload
        if ($request->hasFile('demo_video_file')) {
            $path = $request->file('demo_video_file')->store('videos', 'public');
            $validated['demo_video_file'] = $path;
        }

        // Handle boolean values for checkboxes
        $validated['hero_cta_button_enabled'] = $request->has('hero_cta_button_enabled') ? 1 : 0;
        $validated['demo_video_button_enabled'] = $request->has('demo_video_button_enabled') ? 1 : 0;

        foreach ($validated as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        // Clear cache so changes take effect immediately
        SettingHelper::clearCache();

        return redirect()->route('admin.settings.index')->with('success', 'Settings updated successfully');
    }
}
