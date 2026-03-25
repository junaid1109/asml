<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Helpers\SettingHelper;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $siteName = SettingHelper::get('site_name', 'AMS');
        return view('frontend.contact', compact('siteName'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        Contact::create($validated);

        return back()->with('success', 'Your message has been sent successfully. We will contact you soon!');
    }
}
