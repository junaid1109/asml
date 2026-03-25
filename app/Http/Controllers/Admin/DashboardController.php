<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\TeamMember;
use App\Models\Contact;
use App\Models\Page;

class DashboardController extends \App\Http\Controllers\Controller
{
    public function index()
    {
        $stats = [
            'contacts' => Contact::where('is_read', false)->count(),
            'pages' => Page::count(),
        ];

        $recentContacts = Contact::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentContacts'));
    }
}
