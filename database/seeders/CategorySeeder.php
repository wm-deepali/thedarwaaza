<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $this->seedCategories($this->tree());
        $this->seedProducts();
    }

    /**
     * Creates every category from the tree (parents first, then children).
     * firstOrCreate on slug => safe to re-run, never overwrites admin edits/uploads.
     */
    private function seedCategories(array $nodes, ?int $parentId = null): void
    {
        foreach ($nodes as $i => $node) {
            $category = Category::firstOrCreate(
                ['slug' => $node['slug']],
                [
                    'parent_id'        => $parentId,
                    'name'             => $node['name'],
                    'image'            => $node['image'] ?? null,
                    'meta_title'       => $node['meta_title'] ?? null,
                    'meta_description' => $node['meta_description'] ?? null,
                    'meta_keywords'    => $node['meta_keywords'] ?? null,
                    'canonical_url'    => $node['canonical_url'] ?? null,
                    'sort_order'       => $i + 1,
                    'show_in_navbar'   => $node['navbar'] ?? true,
                    'status'           => $node['status'] ?? true,
                ]
            );

            if (!empty($node['children'])) {
                $this->seedCategories($node['children'], $category->id);
            }
        }
    }

    // Products for leaf categories whose images already exist in public/assets
    private function seedProducts(): void
    {
        $category = Category::where('slug', '2d-membrane-door')->first();

        if (!$category) {
            return;
        }

        // 8.jpg was not used on the old page
        foreach ([1, 2, 3, 4, 5, 6, 7, 9, 10, 11, 12, 13] as $i => $n) {
            Product::firstOrCreate(
                [
                    'category_id' => $category->id,
                    'image'       => "assets/images/products/2d-membrane-door/{$n}.jpg",
                ],
                ['sort_order' => $i + 1, 'status' => true]
            );
        }
    }

    private function n(string $name, string $slug, array $children = [], array $extra = []): array
    {
        return array_merge(['name' => $name, 'slug' => $slug, 'children' => $children], $extra);
    }

    private function tree(): array
    {
        return [

            // ───────────── DOOR ─────────────
            $this->n('Door', 'door', [

                $this->n('Membrane Door', 'membrane-door', [
                    $this->n('Membrane Door', 'membrane-door-pro', [], [
                        'image' => 'assets/images/products/membrane-product/1.jpg',
                    ]),
                    $this->n('3D Membrane Door', '3d-membrane-door', [], [
                        'image' => 'assets/images/products/3d-membrane-door/1.png',
                    ]),
                    $this->n('2D Membrane Door', '2d-membrane-door', [], [
                        'image'            => 'assets/images/products/2d-membrane-door/1.jpg',
                        'meta_title'       => '2D Membrane Door Manufacturer in Barabanki, Unnao, Sandila, Lucknow | The Darwaaza',
                        'meta_description' => 'The Darwaaza is Leading 2D Membrane Door Manufacturer in Barabanki, Unnao, Sandila, Lucknow. Get Here best 2D membrane door at best price',
                        'meta_keywords'    => '2D Membrane Door Manufacturer in Barabanki, 2D Membrane Door Manufacturer in Unnao, 2D Membrane Door Manufacturer in Sandila, 2D Membrane Door Manufacturer in Lucknow',
                        'canonical_url'    => 'https://thedarwaaza.com/2d-membrane-door',
                    ]),
                    $this->n('Chattai Door', 'chattai-membrane', [], [
                        'image' => 'assets/images/products/chattai-door/1.jpg',
                    ]),
                    $this->n('Inlay Membrane Door', 'inlay-membrane-door', [], [
                        'image' => 'assets/images/products/inlay-membrane-door/1.jpg',
                    ]),
                ], [
                    'image'            => 'assets/images/products/membrane-product/1.jpg',
                    'meta_title'       => 'Membrane Door Manufacturer in Barabanki, Unnao, Sandila, Lucknow | The Darwaaza',
                    'meta_description' => 'The Darwaaza is Leading Membrane Door Manufacturer in Barabanki, Unnao, Sandila, Lucknow. Get Here best membrane door at best price',
                    'meta_keywords'    => 'Membrane Door Manufacturer in Barabanki, Membrane Door Manufacturer in Unnao, Membrane Door Manufacturer in Sandila, Membrane Door Manufacturer in Lucknow',
                    'canonical_url'    => 'https://thedarwaaza.com/membrane-door',
                ]),

                // Had no page on the old site (javascript:0 link) -> inactive until it has products
                $this->n('Digital Door', 'digital-door', [], ['status' => false, 'navbar' => false]),

                $this->n('Mica Door', 'mica-door', [
                    $this->n('Plain Mica Door', 'plain-mica-door'),
                    $this->n('Door Skin Door', 'door-skin-door'),
                    $this->n('Routing Mica Door', 'routing-mica-door'),
                    $this->n('Inlay Mica Door', 'inlay-mica-door'),
                ]),

                $this->n('Glass Door', 'glass-door'),
                $this->n('Melamine Door', 'melamine-door'),
                $this->n('HDF Door', 'hdf-door'),
                $this->n('Veneer Door', 'veneer-door'),

                $this->n('Wooden Door', 'wooden-door', [
                    $this->n('Pine Door', 'pine-door'),
                    $this->n('Teak Door', 'teak-door'),
                    $this->n('Carving Door', 'carving-door'),
                ]),

                $this->n('Jaali Door', 'jaali-door', [
                    $this->n('Wooden', 'wooden'),
                    $this->n('Ply', 'ply'),
                ]),

                $this->n('WPC Door', 'wpc-door', [
                    $this->n('Routing Door', 'routing-door'),
                ]),

                $this->n('Customised Door', 'customised-door'),
                $this->n('Double Door', 'double-door'),
                $this->n('HDHMR Door', 'hdhmr-door'),
                $this->n('Prehung Door', 'prehung-door'),
            ]),

            // ───────────── FRAMES ─────────────
            $this->n('Frames', 'frames', [
                $this->n('WPC', 'wpc'),
                $this->n('Wooden', 'wooden-frames'),
                $this->n('Architrave', 'architrave'),
            ]),

            // ───────────── VANITIES ─────────────
            $this->n('Vanities', 'vanities', [
                $this->n('SS', 'ss'),
                $this->n('Acrylic Solid Surface', 'acrylic-solid-surface'),
                $this->n('WPC / HDHMR', 'wpc-hdhmr'),
                $this->n('Mirror', 'mirror'),
                $this->n('Cabinet', 'cabinet'),
            ]),

            // ───────────── TEMPLE ─────────────
            $this->n('Temple', 'temple', [
                $this->n('Wooden', 'wooden-temple'),
                $this->n('Acrylic Solid Surface', 'acrylic-solid-surface-temple'),
            ]),

            // ───────────── PLY ─────────────
            $this->n('Ply', 'plywood', [
                $this->n('Ply / Board', 'ply-board'),
                $this->n('Shuttering Ply', 'shuttering-ply'),
            ]),

            // ───────────── JAALI ─────────────
            $this->n('Jaali', 'jaali-collection', [
                $this->n('Jaali', 'jaali'),
                $this->n('Wave Board', 'wave-board'),
                $this->n('3D Board', '3d-board'),
                $this->n('Acrylic Solid Surface', 'acrylic-solid-surface-jaali'),
            ]),

            // ───────────── Single product pages ─────────────
            $this->n('WPC', 'wpc-main'),
            $this->n('Shelf', 'shelf'),
            $this->n('Kitchen', 'kitchen'),
            $this->n('Wardrobe', 'wardrobe'),
            $this->n('Bed / Furniture', 'bed-furniture'),
        ];
    }
}