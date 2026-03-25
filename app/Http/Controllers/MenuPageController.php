<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuPageController extends Controller
{
    public function index($slug)
    {
        $menu = Menu::getBySlug($slug);

        if (!$menu) {
            abort(404);
        }

        // Route to appropriate controller based on route_name
        if ($menu->route_name === 'team') {
            $teamMembers = \App\Models\TeamMember::where('published', 1)->orderBy('order')->get();
            return view('frontend.team', ['teamMembers' => $teamMembers]);
        }

        if ($menu->route_name === 'contact.index') {
            return view('frontend.contact');
        }

        if ($menu->route_name === 'about') {
            $page = \App\Models\Page::where('published', 1)
                ->where('slug', 'about')
                ->orWhere('title', 'About')
                ->first();
            return view('frontend.about', ['page' => $page]);
        }

        abort(404);
    }
}
