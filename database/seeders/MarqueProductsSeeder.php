<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;

class MarqueProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer la catégorie Marque
        $category = Category::where('slug', 'marque')->first();

        if (!$category) {
            $this->command->error('La catégorie "Marque" n\'existe pas. Veuillez exécuter MarqueCategorySeeder d\'abord.');
            return;
        }

        // Données des produits basées sur marques.html
        $products = [
            [
                'name' => 'T-shirt Signature',
                'description' => 'T-shirt premium au coupe minimaliste, réalisé dans un coton bio de haute qualité. Le logo discret incarne l\'essence de la marque : raffinement et simplicité.',
                'price' => 45000,
                'materials' => 'Coton bio 100% - 240 g/m²',
                'sizes' => 'XS, S, M, L, XL',
                'style' => 'Minimaliste - Streetwear élégant',
                'collection' => 'Signature 2024',
            ],
            [
                'name' => 'Pull Oversized',
                'description' => 'Pull oversized au design épuré, alliant confort et élégance. La coupe contemporaine et les finitions soignées en font une pièce intemporelle.',
                'price' => 85000,
                'materials' => 'Laine mérinos et coton',
                'sizes' => 'S, M, L, XL',
                'style' => 'Oversized - Contemporain',
                'collection' => 'Signature 2024',
            ],
            [
                'name' => 'Pantalon Technique',
                'description' => 'Pantalon fusionnant l\'esthétique streetwear et le savoir-faire technique. Coupe moderne et tissu technique pour une élégance urbaine.',
                'price' => 75000,
                'materials' => 'Twill technique waterproof',
                'sizes' => '30, 32, 34, 36, 38',
                'style' => 'Urbain technique',
                'collection' => 'Urbanité 2024',
            ],
            [
                'name' => 'Jacket Architecturale',
                'description' => 'Veste au design architectural, où chaque ligne a son importance. Structure épurée et détails fonctionnels pour une pièce signature.',
                'price' => 120000,
                'materials' => 'Coton ciré et laine',
                'sizes' => 'S, M, L, XL',
                'style' => 'Architectural - Minimaliste',
                'collection' => 'Architecture 2024',
            ],
            [
                'name' => 'Casquette Structurée',
                'description' => 'Casquette au design repensé, alliant courbes organiques et structure rigoureuse. Accessoire signature qui complète toute tenue.',
                'price' => 35000,
                'materials' => 'Laine et cuir végétalien',
                'sizes' => 'Adjustable (OS)',
                'style' => 'Contemporain - Essentiel',
                'collection' => 'Accessoires 2024',
            ],
            [
                'name' => 'Chaussettes Signature',
                'description' => 'Pack de 3 paires de chaussettes en coton premium. Design minimaliste avec le logo discret, pour un détail qui fait la différence.',
                'price' => 15000,
                'materials' => 'Coton peigné 100%',
                'sizes' => '39-42, 43-46',
                'style' => 'Essentiel - Raffiné',
                'collection' => 'Essentiels 2024',
            ],
        ];

        // Créer les produits
        foreach ($products as $index => $productData) {
            Product::updateOrCreate(
                [
                    'slug' => Str::slug($productData['name']),
                ],
                [
                    'category_id' => $category->id,
                    'name' => $productData['name'],
                    'description' => $productData['description'],
                    'price' => $productData['price'],
                    'materials' => $productData['materials'],
                    'sizes' => $productData['sizes'],
                    'style' => $productData['style'],
                    'collection' => $productData['collection'],
                    'is_available' => true,
                    'is_featured' => $index < 3, // Les 3 premiers sont mis en avant
                    'order' => $index + 1,
                    // Note: Les images devront être ajoutées manuellement via l'admin
                    'image' => null,
                ]
            );
        }

        $this->command->info('✅ ' . count($products) . ' produits Marque créés avec succès !');
        $this->command->warn('⚠️  N\'oubliez pas d\'ajouter les images des produits via le panneau d\'administration.');
    }
}
