<?php

namespace App\Http\Controllers;

use App\Models\TeamMember;
use App\Helpers\SettingHelper;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index()
    {
        $teamMembers = TeamMember::where('published', true)->orderBy('order')->get();
        $siteName = SettingHelper::get('site_name', 'AMS');
        
        return view('frontend.team', compact('teamMembers', 'siteName'));
    }
}
