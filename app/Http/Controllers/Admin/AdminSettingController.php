<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\State;
use App\Models\Setting;
use App\Models\SmtpSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminSettingController extends Controller
{
    // ðŸ”¹ Show form
    public function index(Request $request)
    {
        $states = State::all();
        $general = Setting::first();
        $smtp = SmtpSetting::first();
        $activeTab = $request->tab ?? 'general';

        return view(
            'admin.admin-settings.index',
            compact(
                'smtp',
                'general',
                'states',
                'activeTab',
            )
        );
    }

    public function getCities(Request $request)
    {
        return City::where('state_id', $request->state_id)
            ->orderBy('name')
            ->get(['id', 'name']);
    }

    public function smtpSettingStore(Request $request)
    {
        $validated = $request->validate([
            'smtp_host' => 'required|string|max:255',
            'smtp_port' => 'required|integer',
            'smtp_username' => 'required|string|max:255',
            'smtp_password' => 'required|string',
            'smtp_encryption' => 'required|in:tls,ssl,none',
            'from_name' => 'nullable|string|max:255',
            'from_email' => 'nullable|email|max:255',
            'reply_to_name' => 'nullable|string|max:255',
            'reply_to_email' => 'nullable|email|max:255',
        ]);

        $validated['enquiry_admin']
            = $request->has('enquiry_admin');
        $validated['enquiry_customer']
            = $request->has('enquiry_customer');
            
        SmtpSetting::updateOrCreate(
            ['id' => 1],
            $validated
        );

        return back()->with(
            'success',
            'SMTP settings saved successfully.'
        );
    }

    public function generalSettingStore(Request $request)
    {
        $general = Setting::first();

        $validated = $request->validate([
            'site_name' => 'nullable|string|max:255',
            'tagline' => 'nullable|string|max:255',
            'admin_email' => 'nullable|email|max:255',
            'support_email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'business_address' => 'nullable|string',
            'business_hours' => 'nullable|string|max:500',
            'google_map_url' => 'nullable|string|max:2000',
            'footer_description' => 'nullable|string',
            'facebook' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'linkedin' => 'nullable|url|max:255',
            'youtube' => 'nullable|url|max:255',
            'pinterest' => 'nullable|url|max:255',
            'currency' => 'nullable|string|max:10',
            'currency_symbol' => 'nullable|string|max:10',
            'timezone' => 'nullable|string|max:100',
            'header_logo' => 'nullable|image|mimes:jpg,jpeg,png,svg,webp|max:2048',
            'footer_logo' => 'nullable|image|mimes:jpg,jpeg,png,svg,webp|max:2048',
            'favicon' => 'nullable|image|mimes:jpg,jpeg,png,ico,webp|max:1024',
            'admin_login_logo' => 'nullable|image|mimes:jpg,jpeg,png,svg,webp|max:2048',
            'admin_dashboard_logo' => 'nullable|image|mimes:jpg,jpeg,png,svg,webp|max:2048',
        ]);

        if (
            !empty($validated['google_map_url'])
            && preg_match('/src=["\']([^"\']+)["\']/', $validated['google_map_url'], $m)
        ) {
            $validated['google_map_url'] = html_entity_decode($m[1]);
        }

        $validated['maintenance_mode'] = $request->has('maintenance_mode');

        // Header Logo
        if ($request->hasFile('header_logo')) {
            if ($general && $general->header_logo && Storage::disk('public')->exists($general->header_logo)) {
                Storage::disk('public')->delete($general->header_logo);
            }
            $validated['header_logo'] = $request->file('header_logo')->store('settings', 'public');
        }

        // Footer Logo
        if ($request->hasFile('footer_logo')) {
            if ($general && $general->footer_logo && Storage::disk('public')->exists($general->footer_logo)) {
                Storage::disk('public')->delete($general->footer_logo);
            }
            $validated['footer_logo'] = $request->file('footer_logo')->store('settings', 'public');
        }

        // Favicon
        if ($request->hasFile('favicon')) {
            if ($general && $general->favicon && Storage::disk('public')->exists($general->favicon)) {
                Storage::disk('public')->delete($general->favicon);
            }
            $validated['favicon'] = $request->file('favicon')->store('settings', 'public');
        }

        // Admin Login Page Logo
        if ($request->hasFile('admin_login_logo')) {
            if ($general && $general->admin_login_logo && Storage::disk('public')->exists($general->admin_login_logo)) {
                Storage::disk('public')->delete($general->admin_login_logo);
            }
            $validated['admin_login_logo'] = $request->file('admin_login_logo')->store('settings', 'public');
        }

        // Admin Dashboard Logo
        if ($request->hasFile('admin_dashboard_logo')) {
            if ($general && $general->admin_dashboard_logo && Storage::disk('public')->exists($general->admin_dashboard_logo)) {
                Storage::disk('public')->delete($general->admin_dashboard_logo);
            }
            $validated['admin_dashboard_logo'] = $request->file('admin_dashboard_logo')->store('settings', 'public');
        }

        Setting::updateOrCreate(
            ['id' => 1],
            $validated
        );

        return back()->with(
            'success',
            'General settings updated successfully.'
        );
    }

}