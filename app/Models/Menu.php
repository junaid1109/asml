<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;

class Menu extends Model
{
    protected $fillable = ['label', 'route_name', 'url', 'order', 'active'];

    public static function getActive()
    {
        return static::where('active', true)->orderBy('order')->get();
    }

    public function getLink()
    {
        if ($this->route_name) {
            try {
                return route($this->route_name);
            } catch (\Exception $e) {
                // If the route requires parameters, return the URL field instead
                return $this->url;
            }
        }
        return $this->url;
    }

    public static function getCurrentPageMenu()
    {
        $currentRoute = Route::currentRouteName();
        
        if ($currentRoute === 'home') {
            return static::where('route_name', 'home')->first();
        }

        $baseRoute = explode('.', $currentRoute)[0];
        
        $menu = static::where('route_name', $currentRoute)->first();
        
        if (!$menu) {
            $menu = static::whereRaw("CONCAT(route_name, '') LIKE ?", [$baseRoute . "%"])->first();
        }
        
        return $menu;
    }

    public static function getCurrentPageTitle()
    {
        $menu = self::getCurrentPageMenu();
        return $menu?->label ?? 'Page';
    }

    public static function getBreadcrumbs($customTitle = null)
    {
        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('home')]
        ];

        $currentRoute = Route::currentRouteName();
        
        if ($currentRoute !== 'home') {
            $menu = self::getCurrentPageMenu();
            if ($menu) {
                $breadcrumbs[] = [
                    'label' => $customTitle ?? $menu->label,
                    'url' => null
                ];
            }
        }

        return $breadcrumbs;
    }
}

