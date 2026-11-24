<?php

namespace Database\Seeders;

use App\Models\AboutItem;
use App\Models\AboutPage;
use Illuminate\Database\Seeder;

class AboutPageSeeder extends Seeder
{
    public function run(): void
    {
        $page = AboutPage::getInstance();

        if (filled($page->about_content)) {
            return;
        }

        $page->update([
            'banner_title'  => 'About Us',
            'about_heading' => 'About Us',
            'about_content' =>
                "We're a Lucknow (Uttar Pradesh) based industry with two manufacturing units. We have already set our standards high from other retailers in the industry due to the strong commitment to the service we provide, we are one of the few retailers who are on top of their business, standing out from the others. We are still growing in this industry and want to become one of the largest retailers in the designer doors industry. We are known for providing high levels of personalized services to our clients.\n"
                . "We are a team of qualified staff who master the art of carpentry, and we can assist and advice you in choosing the suitable product for your home and other commercial building. We rest assure you that your products will perfectly fit your space and the doors we provide will make you go awestruck. Moreover, free measurement and quote services we offer makes us different from other retailers.\n"
                . "On the other, we provide free delivery services and make sure that the product to deliver at your doorstep safely. Moreover, you don’t have to worry about the installation of the doors; our expert carpenters will come to your house and install your doors professionally. We design and manufacture some of the authentic looking designer doors for indoor as well as outdoor. Also, with the likes of smart doors, we are the one giving competition to every other retailer in the market.",
            'about_image'      => 'assets/images/about.jpg',
            'why_heading'      => 'Why Choose Us',
            'why_text'         => 'Due to our strong commitment to the services we offer, we have already raised the bar for other retailers in the sector. We are one of the few retailers who are on top of their game and stand out from the competition.',
            'brochure_heading' => "LOOKING FOR\nA UNIQUE DOOR?",
            'brochure_text'    => 'You will love our wide range of products.',
            'brochure_image'   => 'assets/images/brochure.jpg',
            'brochure_link'    => 'pdf/thedarwaaza.pdf',
            'process_heading'  => 'Working process',
        ]);

        $why = [
            ['TECHNICAL MACHINES',   'assets/images/machines.png'],
            ['10000+ CUSTOMERS',     'assets/images/customers.png'],
            ['10000+ DOOR SELL OUT', 'assets/images/sell-out.png'],
        ];

        foreach ($why as $i => [$title, $image]) {
            AboutItem::create(['type' => 'why', 'title' => $title, 'image' => $image, 'sort_order' => $i + 1]);
        }

        $process = [
            ['flaticon-people',     'Meet Customers',     'Our designers will meet the customer and share about our ideas.'],
            ['rot flaticon-technology', 'Discuss Concept', 'After customer meeting, our designer will give some idea to new design.'],
            ['rot icon-check',      'Confirm Agreement',  'With 100% customer satisfaction our designer confirms the agreement.'],
            ['rot flaticon-drawing', 'Design & Install',  'After the confirmation our designing team will design & Completed.'],
        ];

        foreach ($process as $i => [$icon, $title, $text]) {
            AboutItem::create(['type' => 'process', 'icon' => $icon, 'title' => $title, 'text' => $text, 'sort_order' => $i + 1]);
        }
    }
}