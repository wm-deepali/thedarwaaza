<?php

namespace Database\Seeders;

use App\Models\ContactLocation;
use Illuminate\Database\Seeder;

class ContactLocationSeeder extends Seeder
{
    public function run(): void
    {
        if (ContactLocation::exists()) {
            return;
        }

        ContactLocation::insert([
            [
                'title'      => 'Factory Address',
                'address'    => 'Auspicious Creations Pvt Ltd E-195, IIDC, Kursi Road Industrial Area, District- Barabanki, Uttar Pradesh, India.',
                'sort_order' => 1,
                'status'     => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title'      => 'Address',
                'address'    => '5/ 626 Gomtinagar Vistar Shaheed Path Near Sadar Tehsil Lucknow 226010',
                'sort_order' => 2,
                'status'     => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}