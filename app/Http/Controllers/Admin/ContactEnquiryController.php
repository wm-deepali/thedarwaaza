<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ContactEnquiriesExport;
use App\Http\Controllers\Controller;
use App\Models\ContactEnquiry;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ContactEnquiryController extends Controller
{
    // tab key => [label shown, value saved in contact_enquiries.type]
    private const TABS = [
        'contact' => ['Contact',   'Contact Enquiry'],
        'product' => ['Product',   'Product Enquiry'],
        'home'    => ['Home Page', 'Home Page Enquiry'],
        'general' => ['General',   'General Enquiry'],
    ];

    public function index(Request $request)
    {
        $tab = array_key_exists($request->query('tab'), self::TABS) ? $request->query('tab') : 'all';

        $query = ContactEnquiry::with('product')->latest();

        if ($tab !== 'all') {
            $query->where('type', self::TABS[$tab][1]);
        }

        $enquiries = $query->paginate(10)->withQueryString();

        // One query for all tab counts
        $counts = ContactEnquiry::selectRaw(
                'type, COUNT(*) as total, SUM(CASE WHEN is_read = 0 THEN 1 ELSE 0 END) as unread'
            )
            ->groupBy('type')
            ->get()
            ->keyBy('type');

        $tabs = [
            'all' => [
                'label'  => 'All',
                'total'  => (int) $counts->sum('total'),
                'unread' => (int) $counts->sum('unread'),
            ],
        ];

        foreach (self::TABS as $key => [$label, $type]) {
            $tabs[$key] = [
                'label'  => $label,
                'total'  => (int) ($counts[$type]->total ?? 0),
                'unread' => (int) ($counts[$type]->unread ?? 0),
            ];
        }

        $unreadCount = $tabs['all']['unread'];

        return view('admin.contact-enquiries.index', compact('enquiries', 'unreadCount', 'tabs', 'tab'));
    }

    public function show(ContactEnquiry $contactEnquiry)
    {
        if (! $contactEnquiry->is_read) {
            $contactEnquiry->update(['is_read' => true]);
        }

        $contactEnquiry->load('product');

        return view('admin.contact-enquiries.show', ['enquiry' => $contactEnquiry]);
    }

    // File name is unchanged. The export follows the tab you are on.
    public function export(Request $request)
    {
        $tab  = $request->query('tab');
        $type = array_key_exists($tab, self::TABS) ? self::TABS[$tab][1] : null;

        $filename = 'contact_enquiries_' . now()->format('Y_m_d_His') . '.xlsx';

        return Excel::download(new ContactEnquiriesExport($type), $filename);
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids'   => 'required|array|min:1',
            'ids.*' => 'integer|exists:contact_enquiries,id',
        ]);

        $count = ContactEnquiry::whereIn('id', $request->ids)->delete();

        return response()->json(['message' => $count . ' enquiries deleted successfully.']);
    }

    public function destroy(ContactEnquiry $contactEnquiry)
    {
        $contactEnquiry->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Enquiry deleted successfully.',
        ]);
    }
}