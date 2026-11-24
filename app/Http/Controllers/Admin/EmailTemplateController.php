<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use App\Models\Setting;
use App\Models\SmtpSetting;
use App\Services\Email\EmailDispatcher;
use Illuminate\Http\Request;

class EmailTemplateController extends Controller
{
    public function index()
    {
        $emailData = self::getData();

        return view('admin.admin-settings.templates', $emailData);
    }

    /**
     * Supplies $emailTemplates, $emailMeta and $smtpSettings to the templates blade.
     */
    public static function getData(): array
    {
        $meta = EmailTemplate::eventMeta();

        // Keyed by event_key for easy blade lookup
        $templates = EmailTemplate::whereIn('event_key', EmailTemplate::$eventKeys)
            ->get()
            ->keyBy('event_key');

        return [
            'emailMeta' => $meta,
            'emailTemplates' => $templates,
            'smtpSettings' => SmtpSetting::getInstance(),
        ];
    }

    /**
     * AJAX save — POST /admin/settings/email-templates/{eventKey}
     */
    public function save(Request $request, string $eventKey): \Illuminate\Http\JsonResponse
    {
        if (!in_array($eventKey, EmailTemplate::$eventKeys)) {
            return response()->json(['success' => false, 'message' => 'Invalid event key.'], 422);
        }

        $validated = $request->validate([
            'enabled' => 'nullable|boolean',
            'from_name' => 'nullable|string|max:100',
            'from_email' => 'nullable|email|max:150',
            'reply_to_name' => 'nullable|string|max:100',
            'reply_to_email' => 'nullable|email|max:150',
            'cc' => 'nullable|email|max:150',
            'subject' => 'nullable|string|max:255',
            'preview_text' => 'nullable|string|max:255',
            'body' => 'nullable|string',
            // extras
            'expiry_minutes' => 'nullable|integer|min:1|max:1440',
            'admin_email' => 'nullable|email|max:150',
            'stock_threshold' => 'nullable|integer|min:1',
        ]);

        // Build extra_settings for event-specific extras
        $extras = [];

        if ($eventKey === 'password-reset' && isset($validated['expiry_minutes'])) {
            $extras['expiry_minutes'] = $validated['expiry_minutes'];
        }

        // Admin-audience events: the admin email override lives here
        if (in_array($eventKey, ['enquiry-admin', 'new-order-alert', 'low-stock-alert'])) {
            if (isset($validated['admin_email'])) {
                $extras['admin_email'] = $validated['admin_email'];
            }
        }

        if ($eventKey === 'low-stock-alert' && isset($validated['stock_threshold'])) {
            $extras['stock_threshold'] = $validated['stock_threshold'];
        }

        $template = EmailTemplate::firstOrNew(['event_key' => $eventKey]);
        $template->fill([
            'enabled' => (bool) ($validated['enabled'] ?? false),
            'from_name' => $validated['from_name'] ?? null,
            'from_email' => $validated['from_email'] ?? null,
            'reply_to_name' => $validated['reply_to_name'] ?? null,
            'reply_to_email' => $validated['reply_to_email'] ?? null,
            'cc' => $validated['cc'] ?? null,
            'subject' => $validated['subject'] ?? null,
            'preview_text' => $validated['preview_text'] ?? null,
            'body' => $validated['body'] ?? null,
            'extra_settings' => !empty($extras) ? $extras : null,
        ]);
        $template->save();

        return response()->json([
            'success' => true,
            'message' => "'{$eventKey}' email template saved.",
        ]);
    }

    /**
     * AJAX test send — POST /admin/settings/email-templates/test
     */
    public function sendTest(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'event_key' => 'required|string',
            'email' => 'required|email',
        ]);

        $eventKey = $request->input('event_key');
        $email = $request->input('email');

        if (!in_array($eventKey, EmailTemplate::$eventKeys)) {
            return response()->json(['success' => false, 'message' => 'Invalid event key.'], 422);
        }

        // Store details come from settings, not hardcoded
        $general = Setting::first() ?? new Setting();
        $appUrl = url('/');

        $firstPhone = trim(explode(',', (string) $general->phone)[0] ?? '');
        $supportEmail = $general->support_email ?: $general->admin_email;

        // Sample variables — must match EmailTemplate::eventMeta() vars.
        // {message} is HTML (nl2br + escaped), same way the real send will build it.
        $samples = [
            '{customer_name}'  => 'Rahul Sharma',
            '{customer_email}' => $email,
            '{customer_phone}' => '+91 98765 43210',
            '{enquiry_type}'   => 'Product Enquiry',
            '{product_name}'   => 'Designer Membrane Door',
            '{subject}'        => 'Price for 10 doors',
            '{message}'        => nl2br(e("Hello, please share the price and delivery time for 10 doors.\nThanks.")),
            '{enquiry_date}'   => now()->format('d M Y, h:i A'),

            '{store_name}'     => $general->site_name ?: 'The Darwaaza',
            '{logo_url}'       => $appUrl . '/assets/images/logo/logo.png',
            '{shop_url}'       => $appUrl,

            '{support_number}' => $firstPhone,
            '{support_email}'  => $supportEmail,

            '{admin_enquiry_url}' => route('admin.contact-enquiries.index'),
        ];

        $result = EmailDispatcher::sendTest($eventKey, $email, $samples, 'Test Recipient');

        return response()->json([
            'success' => $result['success'],
            'message' => $result['success']
                ? "Test email sent to {$email}"
                : $result['response'],
        ]);
    }
}