<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactLocation;
use Illuminate\Http\Request;

class ContactLocationController extends Controller
{
    public function index()
    {
        $locations = ContactLocation::orderBy('sort_order')->orderBy('id')->get();

        return view('admin.contact-locations.index', compact('locations'));
    }

    public function create()
    {
        return view('admin.contact-locations.form', ['location' => null]);
    }

    public function store(Request $request)
    {
        ContactLocation::create($this->validated($request));

        return redirect()
            ->route('admin.contact-locations.index')
            ->with('success', 'Address added successfully.');
    }

    public function edit(ContactLocation $contactLocation)
    {
        return view('admin.contact-locations.form', ['location' => $contactLocation]);
    }

    public function update(Request $request, ContactLocation $contactLocation)
    {
        $contactLocation->update($this->validated($request));

        return redirect()
            ->route('admin.contact-locations.index')
            ->with('success', 'Address updated successfully.');
    }

    public function destroy(ContactLocation $contactLocation)
    {
        $contactLocation->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Address deleted successfully.',
        ]);
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'title'      => ['required', 'string', 'max:100'],
            'address'    => ['required', 'string', 'max:1000'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:65535'],
        ]);

        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['status']     = $request->boolean('status');

        return $data;
    }
}