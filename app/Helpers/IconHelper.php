<?php

namespace App\Helpers;

use Illuminate\Support\Collection;

class IconHelper
{
    /**
     * Get all Bootstrap Icons from JSON file
     */
    public static function getBootstrapIcons(): Collection
    {
        $path = app_path('Data/bootstrap-icons.json');
        
        if (!file_exists($path)) {
            return collect();
        }

        $json = file_get_contents($path);
        $data = json_decode($json, true);
        
        return collect($data['icons'] ?? []);
    }

    /**
     * Get icon by class name
     */
    public static function getIconByClass(string $class): ?array
    {
        return static::getBootstrapIcons()
            ->firstWhere('class', $class);
    }

    /**
     * Format icons for select dropdown
     */
    public static function getFormattedIcons(): array
    {
        return static::getBootstrapIcons()
            ->map(function ($icon) {
                return [
                    'class' => $icon['class'],
                    'label' => $icon['emoji'] . ' ' . $icon['name'],
                ];
            })
            ->toArray();
    }
}
