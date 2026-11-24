<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    protected $fillable = [
        'event_key',
        'enabled',
        'from_name',
        'from_email',
        'reply_to_name',
        'reply_to_email',
        'cc',
        'subject',
        'preview_text',
        'body',
        'extra_settings',
    ];

    protected $casts = [
        'enabled' => 'boolean',
        'extra_settings' => 'array',
    ];

    /**
     * All valid event keys, in sidebar display order.
     * Changing this list is the only thing needed to add/remove events.
     */
    public static array $eventKeys = [
        'enquiry-admin',
        'enquiry-customer',
    ];

    /**
     * Human-readable metadata for each event key.
     */
    public static function eventMeta(): array
    {
        // Variables shared by both enquiry emails
        $enquiryVars = [
            '{customer_name}'  => 'Customer Name',
            '{customer_email}' => 'Customer Email',
            '{customer_phone}' => 'Customer Phone',
            '{enquiry_type}'   => 'Enquiry Type (Product / Contact / Home Page)',
            '{product_name}'   => 'Product Name (blank for general enquiry)',
            '{subject}'        => 'Subject entered by customer',
            '{message}'        => 'Customer Message',
            '{enquiry_date}'   => 'Date & Time of Enquiry',
            '{store_name}'     => 'Store Name',
            '{logo_url}'       => 'Logo URL',
        ];

        return [
            'enquiry-admin' => [
                'label' => 'New Enquiry Alert',
                'icon' => 'fa fa-bell',
                'desc' => 'Sent to the store admin whenever a customer submits an enquiry or contact form.',
                'default_subject' => 'New {enquiry_type} from {customer_name}',
                'default_preview' => '{customer_name} ({customer_phone}) just sent an enquiry.',
                'default_body' => '<p>Hello,</p>
<p>You have received a new <strong>{enquiry_type}</strong> on <strong>{store_name}</strong>.</p>
<table style="width:100%;border-collapse:collapse;margin:16px 0;font-size:14px">
    <tr><td style="padding:8px 0;color:#666;width:130px">Name</td><td style="padding:8px 0"><strong>{customer_name}</strong></td></tr>
    <tr><td style="padding:8px 0;color:#666">Email</td><td style="padding:8px 0">{customer_email}</td></tr>
    <tr><td style="padding:8px 0;color:#666">Phone</td><td style="padding:8px 0">{customer_phone}</td></tr>
    <tr><td style="padding:8px 0;color:#666">Product</td><td style="padding:8px 0">{product_name}</td></tr>
    <tr><td style="padding:8px 0;color:#666">Received</td><td style="padding:8px 0">{enquiry_date}</td></tr>
</table>
<p style="margin-bottom:6px;color:#666">Message</p>
<div style="border:1px solid #e3e5e8;border-radius:6px;padding:12px 14px;background:#fafafa">{message}</div>
<a href="{admin_enquiry_url}" style="display:inline-block;background:#303d89;color:#fff;padding:12px 28px;border-radius:6px;text-decoration:none;font-weight:600;margin:20px 0">View in Admin Panel</a>',
                'vars' => $enquiryVars + [
                    '{admin_enquiry_url}' => 'Admin link to this enquiry',
                ],
                'extras' => 'admin',
                'audience' => 'admin',
            ],

            'enquiry-customer' => [
                'label' => 'Enquiry Thank You',
                'icon' => 'fa fa-envelope-open',
                'desc' => 'Auto-reply sent to the customer after they submit an enquiry.',
                'default_subject' => 'Thank you for your enquiry, {customer_name}',
                'default_preview' => 'We have received your enquiry and will contact you soon.',
                'default_body' => '<p>Hi {customer_name},</p>
<p>Thank you for contacting <strong>{store_name}</strong>. We have received your enquiry and our team will get back to you shortly.</p>
<p style="margin-bottom:6px;color:#666">Your message</p>
<div style="border:1px solid #e3e5e8;border-radius:6px;padding:12px 14px;background:#fafafa">{message}</div>
<p>Need a quicker response? Call us on {support_number} or reply to this email.</p>
<p>Warm regards,<br>Team {store_name}</p>',
                'vars' => $enquiryVars + [
                    '{support_number}' => 'Support Number',
                    '{support_email}'  => 'Support Email',
                    '{shop_url}'       => 'Website URL',
                ],
                'extras' => null,
                'audience' => 'customer',
            ],
        ];
    }

    /**
     * Nav badge — same logic as SmsTemplate::navBadge()
     */
    public function navBadge(): array
    {
        if ($this->enabled) {
            return ['class' => 'active-badge', 'label' => 'On'];
        }

        if (!empty($this->body)) {
            return ['class' => 'draft-badge', 'label' => 'Draft'];
        }

        return ['class' => 'off-badge', 'label' => 'Off'];
    }

    /**
     * Status badge HTML for the panel header.
     */
    public function statusBadgeHtml(): string
    {
        if ($this->enabled) {
            return '<span style="font-size:11px;font-weight:700;padding:3px 10px;border-radius:20px;background:var(--green-bg);color:var(--green);border:1px solid var(--green-border)">
                        <i class="fa fa-circle" style="font-size:7px;margin-right:4px"></i>Active
                    </span>';
        }

        if (!empty($this->body)) {
            return '<span style="font-size:11px;font-weight:700;padding:3px 10px;border-radius:20px;background:var(--amber-bg);color:var(--amber);border:1px solid var(--amber-border)">Draft</span>';
        }

        return '<span style="font-size:11px;font-weight:700;padding:3px 10px;border-radius:20px;background:var(--bg);color:var(--text-hint);border:1px solid var(--border)">Off</span>';
    }
}