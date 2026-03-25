<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends \App\Http\Controllers\Controller
{
    public function __construct()
    {
        // Viewers can only view, not delete
        $this->middleware(function ($request, $next) {
            if (auth()->user()->role === 'viewer' && in_array($request->route()->getActionMethod(), ['destroy', 'deleteAll'])) {
                abort(403, 'Unauthorized. Viewers have read-only access.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $contacts = Contact::latest()->paginate(15);
        return view('admin.contacts.index', compact('contacts'));
    }

    public function show(Contact $contact)
    {
        $contact->update(['is_read' => true]);
        return view('admin.contacts.show', compact('contact'));
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();
        return redirect()->route('admin.contacts.index')->with('success', 'Contact deleted successfully');
    }

    public function deleteAll(Request $request)
    {
        Contact::whereIn('id', $request->input('ids', []))->delete();
        return redirect()->route('admin.contacts.index')->with('success', 'Selected contacts deleted successfully');
    }
}
