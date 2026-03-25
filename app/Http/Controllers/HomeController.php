<?php

namespace App\Http\Controllers;

use App\Models\TeamMember;
use App\Models\Page;
use App\Models\Setting;
use App\Models\HomeSection;
use App\Models\Portfolio;
use App\Models\Feature;
use App\Models\AboutParagraph;
use App\Helpers\SettingHelper;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $siteName = SettingHelper::get('site_name', 'AMS');
        $siteTagline = SettingHelper::get('site_tagline', 'Professional Business Solutions');
        
        // Get homepage sections data
        $homeSections = HomeSection::where('is_active', true)->orderBy('display_order')->get();
        
        // Get portfolio items
        $portfolios = Portfolio::where('is_active', true)->orderBy('display_order')->get();
        
        // Get features
        $features = Feature::orderBy('order')->get();
        
       
        return view('frontend.index', compact(
            'siteName',
            'siteTagline',
            'homeSections',
            'portfolios',
            'features',
        ));
    }

    public function about()
    {
        $siteName = SettingHelper::get('site_name', 'AMS');
        $page = Page::where('slug', 'about')->where('published', true)->first();
        $homeSections = HomeSection::where('is_active', true)->orderBy('display_order')->get();
        
        // Get about paragraphs
        $aboutParagraphs = AboutParagraph::where('is_active', true)->ordered()->get();
        
        // Get portfolio items
        $portfolios = Portfolio::where('is_active', true)->ordered()->get();
        
        return view('frontend.about', compact('page',  'siteName', 'homeSections', 'aboutParagraphs', 'portfolios'));
    }
}
