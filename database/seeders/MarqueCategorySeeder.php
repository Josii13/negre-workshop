<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class MarqueCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::firstOrCreate(
            ['slug' => 'marque'],
            [
                'name' => 'Marque',
                'description' => '"Le minimalisme, l\'élégance et la raffinerie deviennent ici les vecteurs d\'un streetwear réinventé. Mon intention est de transcender son image première pour l\'introduire, avec mesure et subtilité, dans tous les espaces sociaux."',
                'banner_title' => 'Marque',
                'banner_description' => 'Streetwear réinventé - où le minimalisme rencontre l\'élégance pour créer une expression universelle de la contemporanéité.',
                'order' => 3,
                'is_active' => true,
            ]
        );

        $this->command->info('Catégorie Marque créée avec succès !');
    }
}
