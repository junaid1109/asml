<?php

namespace App\Helpers;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingHelper
{
    /**
     * Get a setting value by key
     */
    public static function get($key, $default = null)
    {
        try {
            return Cache::remember("setting_{$key}", 3600, function () use ($key, $default) {
                $setting = Setting::where('key', $key)->first();
                return $setting ? $setting->value : $default;
            });
        } catch (\Exception $e) {
            return $default;
        }
    }

    /**
     * Get all settings
     */
    public static function all()
    {
        try {
            return Cache::remember('all_settings', 3600, function () {
                return Setting::pluck('value', 'key')->toArray();
            });
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Clear settings cache
     */
    public static function clearCache()
    {
        Cache::forget('all_settings');
        Cache::flush();
    }
}
