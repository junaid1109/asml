<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Helpers\SettingHelper;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show(Page $page)
    {
        if (!$page->published) {
            abort(404);
        }
        $siteName = SettingHelper::get('site_name', 'AMS');
        return view('frontend.page', compact('page', 'siteName'));
    }
}
