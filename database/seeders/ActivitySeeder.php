<?php

namespace Database\Seeders;

use App\Models\Activity;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $activities = [
            // Atelier
            [
                'title' => 'Espace Principal',
                'description' => 'Le cœur battant du NÈGRE Workshop. Cet espace de 120m² est spécialement conçu pour la création artistique, équipé de tout le matériel nécessaire pour la peinture, le dessin et les installations.',
                'price' => '450 000 FCFA',
                'type' => 'Atelier de création',
                'frequency' => 'Accès libre sur réservation',
                'capacity' => '5 artistes simultanément',
                'audience' => 'Artistes professionnels et amateurs',
                'tab' => 'atelier',
                'image' => 'img1.jpg',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Zone d\'Exposition',
                'description' => 'Espace galerie de 60m² dédié à la mise en valeur des œuvres. Éclairage professionnel, cimaises modulables, parquet en chêne.',
                'price' => '450 000 FCFA',
                'type' => 'Galerie d\'exposition',
                'frequency' => 'Expositions mensuelles',
                'capacity' => '30 personnes',
                'audience' => 'Collectionneurs et amateurs d\'art',
                'tab' => 'atelier',
                'image' => 'img1.jpg',
                'order' => 2,
                'is_active' => true,
            ],
            // Activités
            [
                'title' => 'Week-end Peinture et Chill',
                'description' => 'Sessions détendues de peinture dans une ambiance conviviale et musicale. Matériel fourni, guidance artistique légère, moments d\'échange entre participants.',
                'price' => '450 000 FCFA',
                'type' => 'Atelier loisir créatif',
                'frequency' => 'Tous les week-ends',
                'capacity' => '12 participants',
                'audience' => 'Tous niveaux, adultes',
                'tab' => 'activites',
                'image' => 'img1.jpg',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Podcast',
                'description' => 'Studio d\'enregistrement équipé pour capturer les récits d\'artistes et créateurs. Discussions authentiques sur les processus créatifs, les défis et les inspirations.',
                'price' => '450 000 FCFA',
                'type' => 'Production audio',
                'frequency' => '2 enregistrements/mois',
                'capacity' => '4 personnes en studio',
                'audience' => 'Artistes et public curieux',
                'tab' => 'activites',
                'image' => 'img1.jpg',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Art Thérapie',
                'description' => 'Séances guidées par des art-thérapeutes certifiés. Utilisation des mediums artistiques pour l\'expression émotionnelle et le développement personnel.',
                'price' => '450 000 FCFA',
                'type' => 'Atelier thérapeutique',
                'frequency' => 'Séances hebdomadaires',
                'capacity' => '8 participants max',
                'audience' => 'Adultes en recherche de bien-être',
                'tab' => 'activites',
                'image' => 'img1.jpg',
                'order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($activities as $activity) {
            Activity::create($activity);
        }
    }
}

