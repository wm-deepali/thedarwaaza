<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ContactEnquiry;
use App\Models\ContactLocation;
use App\Models\Product;
use App\Models\Setting;
use App\Services\Email\EmailDispatcher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FrontController extends Controller
{
    public function home()
    {
        $categories = Category::whereNull('parent_id')
            ->where('status', 1)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('front-pages.home', compact('categories'));
    }

    public function categoryDetail(string $slug)
    {
        $category = Category::where('slug', $slug)
            ->where('status', 1)
            ->with('activeChildren')
            ->firstOrFail();

        $seoOverride = $this->categorySeo($category);

        // Has sub categories -> show sub category cards
        if ($category->activeChildren->isNotEmpty()) {
            return view('front-pages.category-detail', compact('category', 'seoOverride'));
        }

        // No sub categories -> show products
        $products = $category->products()->where('status', 1)->get();

        return view('front-pages.category-products', compact('category', 'products', 'seoOverride'));
    }

    /**
     * Per-category SEO, read by partials/seo.blade.php as $seoOverride.
     */
    private function categorySeo(Category $category): object
    {
        $site = Setting::first()?->site_name;
        $title = $category->meta_title ?: $category->name . ($site ? ' | ' . $site : '');

        return (object) [
            'meta_title' => $title,
            'meta_description' => $category->meta_description,
            'meta_keywords' => $category->meta_keywords,
            'canonical_url' => $category->canonical_url ?: route('category.show', $category->slug),
            'robots' => 'index, follow',
            'og_title' => $title,
            'og_description' => $category->meta_description,
            'og_image' => $category->banner_url,
            'og_type' => 'website',
        ];
    }

    public function contact()
    {
        $setting = Setting::first() ?? new Setting();
        $locations = ContactLocation::active()->get();

        $phones = collect(explode(',', (string) $setting->phone))
            ->map(fn($p) => trim($p))
            ->filter()
            ->values();

        $email = $setting->support_email ?: $setting->admin_email;

        return view('front-pages.contact', compact('setting', 'locations', 'phones', 'email'));
    }

    public function enquiry(Request $request)
    {
        $product = null;

        if ($request->filled('product')) {
            $product = Product::where('status', 1)->find($request->query('product'));
        }

        return view('front-pages.enquiry', compact('product'));
    }

    public function enquirySubmit(Request $request)
    {
        $successMessage = 'Thank you! We will contact you soon.';

        // Honeypot: bots fill this, silently pretend success
        if ($request->filled('form_botcheck')) {
            return redirect()->back()->with('success', $successMessage);
        }

        $data = $request->validate([
            'form_type' => ['nullable', 'in:contact,enquiry,home'],
            'product_id' => ['nullable', 'integer', 'exists:products,id'],
            'form_name' => ['required', 'string', 'max:150'],
            'form_email' => ['required', 'email', 'max:150'],
            'form_phone' => ['nullable', 'string', 'max:30'],
            'form_subject' => ['nullable', 'string', 'max:200'],
            'form_message' => ['nullable', 'string', 'max:3000'],
        ]);

        // No separate subject column: keep it at the top of the message
        $message = trim(
            (filled($data['form_subject'] ?? null) ? 'Subject: ' . $data['form_subject'] . "\n\n" : '')
            . ($data['form_message'] ?? '')
        );

        // Decide enquiry type
        if (($data['form_type'] ?? null) === 'contact') {
            $type = 'Contact Enquiry';
        } elseif (($data['form_type'] ?? null) === 'home') {
            $type = 'Home Page Enquiry';
        } elseif (filled($data['product_id'] ?? null)) {
            $type = 'Product Enquiry';
        } else {
            $type = 'General Enquiry';
        }

        $enquiry = ContactEnquiry::create([
            'product_id' => $data['product_id'] ?? null,
            'name' => $data['form_name'],
            'email' => $data['form_email'],
            'phone' => $data['form_phone'] ?? null,
            'type' => $type,
            'message' => $message !== '' ? $message : null,
            'ip_address' => $request->ip(),
            'is_read' => false,
        ]);

        $this->sendEnquiryEmails($enquiry, $type);

        return redirect()->back()->with('success', $successMessage);
    }

    /**
     * Fire enquiry emails. A mail problem never breaks the form submit.
     * Each email is still gated by its SMTP toggle and its EmailTemplate row.
     */
    private function sendEnquiryEmails(ContactEnquiry $enquiry, string $type): void
    {
        try {
            $setting = Setting::first();
            $adminEmail = $setting?->support_email ?: $setting?->admin_email;
            $productName = $enquiry->product_id
                ? (Product::find($enquiry->product_id)?->name ?? '')
                : '';

            // e() escapes user input because the template body is sent as HTML
            $variables = [
                '{enquiry_id}' => $enquiry->id,
                '{customer_name}' => e($enquiry->name),
                '{customer_email}' => e($enquiry->email),
                '{customer_phone}' => e($enquiry->phone ?? ''),
                '{enquiry_type}' => e($type),
                '{product_name}' => e($productName),
                '{message}' => nl2br(e($enquiry->message ?? '')),
            ];

            // Admin alert
            if ($adminEmail) {
                EmailDispatcher::send('enquiry-admin', $adminEmail, $variables);
            }

            // Customer acknowledgement
            EmailDispatcher::send('enquiry-customer', $enquiry->email, $variables, $enquiry->name);
        } catch (\Throwable $e) {
            Log::error('Enquiry email failed: ' . $e->getMessage());
        }
    }
}