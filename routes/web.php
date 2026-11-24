<?php

use App\Http\Controllers\Admin\{
    SeoController,
    LogoutController,
    ProductController,
    RedirectController,
    CategoryController,
    SystemLogController,
    DashboardController,
    AdminSettingController,
    EmailTemplateController,
    ProfileSettingController,
    ContactEnquiryController,
    ContactLocationController
};

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\Auth\LoginController;

Route::middleware('maintenance.mode')->group(function () {

    Route::controller(FrontController::class)->group(function () {
        Route::get('/', 'home')->name('home');

        Route::view('/about', 'front-pages.about')->name('about');
        Route::get('/enquiry', 'enquiry')->name('enquiry');
        Route::post('/enquiry', 'enquirySubmit')->name('enquiry.submit');
        Route::get('/contact', 'contact')->name('contact');
        Route::view('/strength', 'front-pages.strength')->name('strength');

        Route::get('category/{slug}', 'categoryDetail')->where('slug', '[A-Za-z0-9\-]+')->name('category.show');
    });

});

Route::get('/get-cities', [AdminSettingController::class, 'getCities'])->name('get-cities');

// Admin Routes list
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
});


Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware(['auth', 'admin.timeout'])->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('/profile-setting', ProfileSettingController::class);
        Route::post('/resetpassword', [ProfileSettingController::class, 'resetPassword'])->name('reset.password');

        Route::resource('categories', CategoryController::class)->except(['show']);
        Route::resource('products', ProductController::class)->only(['index', 'store', 'update', 'destroy']);

        Route::resource('contact-locations', ContactLocationController::class)->except(['show']);

        Route::get('contact-enquiries', [ContactEnquiryController::class, 'index'])->name('contact-enquiries.index');
        Route::get('contact-enquiries/export', [ContactEnquiryController::class, 'export'])->name('contact-enquiries.export');
        Route::delete('contact-enquiries/bulk-delete', [ContactEnquiryController::class, 'bulkDelete'])->name('contact-enquiries.bulk-delete');
        Route::get('contact-enquiries/{contact_enquiry}', [ContactEnquiryController::class, 'show'])->name('contact-enquiries.show');
        Route::delete('contact-enquiries/{contact_enquiry}', [ContactEnquiryController::class, 'destroy'])->name('contact-enquiries.destroy');

        Route::get('/seo', [SeoController::class, 'index'])->name('seo.index');
        Route::put('/seo/{id}', [SeoController::class, 'update'])->name('seo.update');

        // Admin Settings routes
        Route::get('/admin-setting', [AdminSettingController::class, 'index'])->name('admin-setting.index');
        Route::post('/smtp-settings/store', [AdminSettingController::class, 'smtpSettingStore'])->name('smtp-settings.store');
        Route::post('/settings/general', [AdminSettingController::class, 'generalSettingStore'])->name('settings.general.store');
        Route::get('/security/system-logs', [SystemLogController::class, 'index'])->name('security.system-logs');
        Route::get('/settings/email-templates', [EmailTemplateController::class, 'index'])->name('settings.email-templates.index');
        Route::post('settings/email-templates/test', [EmailTemplateController::class, 'sendTest'])->name('settings.email-templates.test');
        Route::post('settings/email-templates/{eventKey}', [EmailTemplateController::class, 'save'])->name('settings.email-templates.save');

        Route::prefix('redirect-settings')->name('redirect-settings.')->group(function () {
            Route::get('/', [RedirectController::class, 'index'])->name('index');
            Route::post('/', [RedirectController::class, 'store'])->name('store');
            Route::put('/{redirect}', [RedirectController::class, 'update'])->name('update');
            Route::delete('/{redirect}', [RedirectController::class, 'destroy'])->name('destroy');
            Route::post('/bulk-delete', [RedirectController::class, 'bulkDestroy'])->name('bulk-delete');
            Route::post('/bulk-toggle', [RedirectController::class, 'bulkToggle'])->name('bulk-toggle');
            Route::post('/{redirect}/toggle', [RedirectController::class, 'toggleStatus'])->name('toggle');
            Route::get('/export', [RedirectController::class, 'exportCsv'])->name('export');
            Route::get('/template', [RedirectController::class, 'downloadTemplate'])->name('template');
            Route::post('/import', [RedirectController::class, 'importCsv'])->name('import');
        });

        Route::get('/logout', [LogoutController::class, 'logout']);


    });
});


// ══════════════════════════════════════════════════
// FALLBACK ROUTE — must be the very last route registered.
// Only runs when NOTHING above matched (i.e. a genuine 404).
// Checks the redirects table before giving up with a real 404/410.
// ══════════════════════════════════════════════════
Route::fallback(function () {
    $path = '/' . ltrim(request()->path(), '/');

    $redirect = \App\Models\Redirect::active()->where('from_url', $path)->first();

    if ($redirect) {
        $redirect->increment('hits');

        if ($redirect->type === '410') {
            abort(410);
        }

        return redirect($redirect->to_url, (int) $redirect->type);
    }

    abort(404);
});
