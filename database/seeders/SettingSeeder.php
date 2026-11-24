<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            // General
            'site_name'            => 'The Darwaaza',
            'tagline'              => null,
            'header_logo'          => $this->copyToStorage('assets/images/logo/logo.png', 'settings/header-logo.png'),
            'footer_logo'          => null,
            'favicon'              => $this->copyToStorage('assets/images/favicons/favicon-32x32.png', 'settings/favicon.png'),
            'admin_login_logo'     => null,
            'admin_dashboard_logo' => null,

            // Contact
            'admin_email'          => 'thehamam99@gmail.com',
            'support_email'        => 'thehamam99@gmail.com',
            'phone'                => '8423437500, 9696333549, 9415116688, 8858464795',
            'whatsapp'             => '9696333549',
            'business_address'     => '5/ 626 Gomtinagar Vistar Shaheed Path Near Sadar Tehsil Lucknow 226010',
            'business_hours'       => null,
            'google_map_url'       => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3560.0614520483236!2d80.92167791504335!3d26.83799768315979!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x399bfdb44787aacb%3A0xb71b336be205a061!2sThe%20Hamam%20The%20Darwaaza!5e0!3m2!1sen!2sin!4v1677669256990!5m2!1sen!2sin',

            // Footer
            'footer_description'   => "We're a Lucknow (Uttar Pradesh) based industry with two manufacturing units. We have already set our standards high from other retailers in the industry due to the strong commitment to the service we provide, we are one of the few retailers who are on top of their business, standing out from the others. We are still growing in this industry and want to become one of the largest retailers in the designer doors industry.",
            'footer_copyright'     => 'Copyright © 2023 The Hamam Local | All Right Reserved',

            // Social
            'facebook'             => 'https://www.facebook.com/TheDarwaaza?mibextid=ZbWKwL',
            'instagram'            => null,
            'twitter'              => null,
            'linkedin'             => null,
            'youtube'              => null,
            'pinterest'            => 'https://pin.it/2iNLhCj',

            // Regional
            'currency'             => 'INR',
            'currency_symbol'      => '₹',
            'timezone'             => 'Asia/Kolkata',

            // System
            'maintenance_mode'      => false,
            'admin_session_timeout' => 30,
        ];

        $setting = Setting::first() ?? new Setting();

        // Sirf khali fields bharo. blank() null aur '' ko khali maanta hai, false/0 ko nahi.
        foreach ($defaults as $key => $value) {
            if (blank($setting->{$key})) {
                $setting->{$key} = $value;
            }
        }

        $setting->save();
    }

    /**
     * public/ ki file ko storage/app/public me copy karke relative path return karta hai.
     * File nahi mili to null (field khali rahegi).
     */
    private function copyToStorage(string $publicPath, string $storagePath): ?string
    {
        $source = public_path($publicPath);

        if (! File::exists($source)) {
            return null;
        }

        Storage::disk('public')->put($storagePath, File::get($source));

        return $storagePath;
    }
}