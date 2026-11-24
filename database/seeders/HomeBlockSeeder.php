<?php

namespace Database\Seeders;

use App\Models\HomeBlock;
use Illuminate\Database\Seeder;

class HomeBlockSeeder extends Seeder
{
    public function run(): void
    {
        if (HomeBlock::exists()) {
            return;
        }

        $rows = [
            // Slider
            ['slider', 'Modern Designer Door Manufacturing In India', 'Customized And Handcrafted Doors In All Price Ranges', 'assets/images/slider/1.jpg', null],
            ['slider', "Old Ways Won't\nOpen New Door", null, 'assets/images/slider/2.jpg', null],
            ['slider', null, null, 'assets/images/slider/3.jpg', null],

            // Feature cards
            ['feature', "Smart Doors\nDesign", null, 'assets/images/smart-door.jpg', null],
            ['feature', "Front Doors\nDesign", null, 'assets/images/front-doors-design.jpg', null],
            ['feature', "Double Doors\nDesign", null, 'assets/images/double-door-design-1.jpg', null],
            ['feature', "Sliding Doors\nDesign", null, 'assets/images/sliding-doors-design.jpg', null],

            // Top sellers
            ['top_seller', 'Interior Smart Doors', null, 'assets/images/product/interior-smart.jpg', null],
            ['top_seller', 'Front Door Glass', null, 'assets/images/product/front-door.jpg', null],
            ['top_seller', 'Exterior Double Doors', null, 'assets/images/product/exterior-double-doors.jpg', null],
            ['top_seller', 'Sliding Glass Doors', null, 'assets/images/product/sliding-glass-doors.jpg', null],
        ];

        $order = [];

        foreach ($rows as [$section, $title, $subtitle, $image, $link]) {
            $order[$section] = ($order[$section] ?? 0) + 1;

            HomeBlock::create([
                'section'    => $section,
                'title'      => $title,
                'subtitle'   => $subtitle,
                'image'      => $image,
                'link'       => $link,
                'sort_order' => $order[$section],
                'status'     => true,
            ]);
        }
    }
}