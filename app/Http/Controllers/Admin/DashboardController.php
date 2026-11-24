<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        $startThis = $now->copy()->startOfMonth();
        $startLast = $now->copy()->subMonth()->startOfMonth();
        $endLast   = $now->copy()->subMonth()->endOfMonth();

        return view('admin.dashboard.index');
    }

    private function percentChange($old, $new): float
    {
        if ($old <= 0) {
            return $new > 0 ? 100.0 : 0.0;
        }

        return round((($new - $old) / $old) * 100, 1);
    }
}