<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $peinture = Category::where('slug', 'peinture')->first();
        $design = Category::where('slug', 'design')->first();

        // Produits Peinture
        $peintureProducts = [
            [
                'name' => 'Horizon Rouge',
                'slug' => 'horizon-rouge',
                'description' => 'Cette œuvre vibrante capture l\'essence d\'un coucher de soleil africain. Les nuances de rouge et d\'orange se fondent harmonieusement pour créer une atmosphère chaleureuse et contemplative.',
                'price' => 450000,
                'dimensions' => '80 x 100 cm',
                'technique' => 'Acrylique',
                'support' => 'Toile',
                'year' => '2024',
                'image' => 'img1.jpg',
                'order' => 1,
            ],
            [
                'name' => 'Bleu Profond',
                'slug' => 'bleu-profond',
                'description' => 'Une plongée dans les profondeurs de l\'océan. Cette toile explore les différentes tonalités du bleu, évoquant la sérénité et le mystère des eaux profondes.',
                'price' => 520000,
                'dimensions' => '90 x 120 cm',
                'technique' => 'Huile',
                'support' => 'Toile',
                'year' => '2024',
                'image' => 'img1.jpg',
                'order' => 2,
            ],
            [
                'name' => 'Soleil d\'Afrique',
                'slug' => 'soleil-afrique',
                'description' => 'Célébration éclatante de la lumière africaine. Cette œuvre majestueuse marie des couleurs chaudes et éclatantes qui évoquent la chaleur et l\'énergie du continent.',
                'price' => 680000,
                'dimensions' => '100 x 120 cm',
                'technique' => 'Acrylique',
                'support' => 'Toile',
                'year' => '2023',
                'image' => 'img1.jpg',
                'order' => 3,
            ],
        ];

        foreach ($peintureProducts as $product) {
            Product::create(array_merge($product, ['category_id' => $peinture->id]));
        }

        // Produits Design
        $designProducts = [
            [
                'name' => 'Totem Étagère',
                'slug' => 'totem-etagere',
                'description' => 'Une étagère sculpturale qui défie la gravité. Cette pièce unique allie fonctionnalité et expression artistique, créant un point focal remarquable dans n\'importe quel espace.',
                'price' => 850000,
                'dimensions' => '180 x 45 x 35 cm',
                'materials' => 'Bois d\'ébène et laiton',
                'style' => 'Contemporain sculptural',
                'year' => '2024',
                'image' => 'img1.jpg',
                'order' => 1,
            ],
            [
                'name' => 'Console Élégance',
                'slug' => 'console-elegance',
                'description' => 'Console au design épuré et raffiné. Ses lignes nettes et ses matériaux nobles en font une pièce intemporelle qui s\'intègre parfaitement dans les intérieurs modernes.',
                'price' => 720000,
                'dimensions' => '120 x 40 x 80 cm',
                'materials' => 'Acajou massif et métal brossé',
                'style' => 'Moderne minimaliste',
                'year' => '2024',
                'image' => 'img1.jpg',
                'order' => 2,
            ],
        ];

        foreach ($designProducts as $product) {
            Product::create(array_merge($product, ['category_id' => $design->id]));
        }

        // Note: Les produits Marque sont gérés par MarqueProductsSeeder
    }
}

