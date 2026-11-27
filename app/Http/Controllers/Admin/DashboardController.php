<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ContactEnquiry;
use App\Models\ContactLocation;
use App\Models\HomeBlock;
use App\Models\Product;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        $startThis = $now->copy()->startOfMonth();
        $startLast = $now->copy()->subMonth()->startOfMonth();
        $endLast   = $now->copy()->subMonth()->endOfMonth();

        // ── Enquiries ──────────────────────────────────────────
        $enquiriesTotal = ContactEnquiry::count();
        $enquiriesThis  = ContactEnquiry::where('created_at', '>=', $startThis)->count();
        $enquiriesLast  = ContactEnquiry::whereBetween('created_at', [$startLast, $endLast])->count();
        $enquiryChange  = $this->percentChange($enquiriesLast, $enquiriesThis);
        $enquiriesToday = ContactEnquiry::whereDate('created_at', $now->toDateString())->count();

        // Last 6 months chart
        $chartLabels = [];
        $chartData   = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = $now->copy()->subMonths($i);
            $chartLabels[] = $month->format('M Y');
            $chartData[]   = ContactEnquiry::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
        }

        $latestEnquiries = ContactEnquiry::latest()->take(8)->get();

        // ── Catalog ────────────────────────────────────────────
        $productsTotal  = Product::count();
        $productsActive = Schema::hasColumn('products', 'status')
            ? Product::where('status', 1)->count()
            : $productsTotal;
        $productsThis   = Product::where('created_at', '>=', $startThis)->count();

        $categoriesTotal = Category::whereNull('parent_id')->count();
        $subCategories   = Category::whereNotNull('parent_id')->count();

        $recentProducts = Product::latest()->take(6)->get();

        // Products per top-level category (top 6)
        $categoryStats = Category::whereNull('parent_id')
            ->withCount('products')
            ->orderByDesc('products_count')
            ->take(6)
            ->get();
        $maxCategoryProducts = max(1, (int) $categoryStats->max('products_count'));

        // ── Website content ────────────────────────────────────
        $homeBlocks       = HomeBlock::count();
        $contactLocations = ContactLocation::count();

        return view('admin.dashboard.index', compact(
            'enquiriesTotal', 'enquiriesThis', 'enquiriesLast', 'enquiryChange', 'enquiriesToday',
            'chartLabels', 'chartData', 'latestEnquiries',
            'productsTotal', 'productsActive', 'productsThis',
            'categoriesTotal', 'subCategories',
            'recentProducts', 'categoryStats', 'maxCategoryProducts',
            'homeBlocks', 'contactLocations'
        ));
    }

    private function percentChange($old, $new): float
    {
        if ($old <= 0) {
            return $new > 0 ? 100.0 : 0.0;
        }

        return round((($new - $old) / $old) * 100, 1);
    }
}