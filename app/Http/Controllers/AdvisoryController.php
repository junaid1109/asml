<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdvisoryController extends Controller
{
    /**
     * Display the advisory page
     */
    public function index()
    {
        $siteName = \App\Helpers\SettingHelper::get('site_name', 'AMS');
        return view('frontend.advisory.index', compact('siteName'));
    }

    /**
     * Display a specific advisory
     */
    public function show($id)
    {
        return $this->index();
    }
}
