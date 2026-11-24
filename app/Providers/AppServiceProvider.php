<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\SeoPage;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('*', function ($view) {
            // Built once per request, then reused for every view / partial
            static $shared = null;

            if ($shared === null) {
                $name = Route::currentRouteName();

                $shared = [
                    'seo' => $name ? SeoPage::forKey($name) : null,
                    // new Setting() avoids "property on null" errors if the row doesn't exist yet
                    'general' => Setting::first() ?? new Setting(),
                ];
            }

            $view->with($shared);
        });

        // Navbar + footer categories (only the public layout needs them)
        View::composer('layouts.app', function ($view) {
            $view->with('navCategories', Cache::rememberForever('nav_categories', function () {
                return Category::whereNull('parent_id')
                    ->where('status', 1)
                    ->where('show_in_navbar', 1)
                    ->orderBy('sort_order')
                    ->orderBy('name')
                    ->with('navChildren.navChildren')   // Door > Membrane Door > 2D Membrane Door
                    ->get();
            }));
        });
    }
}