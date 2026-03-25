<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    /**
     * Display the portfolio page
     */
    public function index()
    {
        $siteName = \App\Helpers\SettingHelper::get('site_name', 'AMS');
        $homeSections = \App\Models\HomeSection::where('is_active', true)
            ->orderBy('display_order')
            ->get();
        $portfolios = Portfolio::where('is_active', true)
            ->orderBy('display_order')
            ->get();

        return view('frontend.portfolio.index', compact('siteName', 'homeSections', 'portfolios'));
    }

    /**
     * Display a specific portfolio item
     */
    public function show($id)
    {
        return $this->index();
    }
}
