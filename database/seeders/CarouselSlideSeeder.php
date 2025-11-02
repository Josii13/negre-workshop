<?php

namespace Database\Seeders;

use App\Models\CarouselSlide;
use Illuminate\Database\Seeder;

class CarouselSlideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $slides = [
            [
                'title' => 'Frederic N\'DA',
                'subtitle' => 'Artiste Peintre & Designer',
                'description' => 'Artiste peintre et designer ivoirien, Frederic N\'DA développe un univers artistique où la peinture contemporaine dialogue avec le design mobilier.',
                'image' => 'img1.jpg',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Exploration Artistique',
                'subtitle' => 'Formes, Textures & Couleurs',
                'description' => 'Son travail explore les formes, les textures et les couleurs, créant des pièces uniques qui transcendent les frontières entre l\'art et le fonctionnel.',
                'image' => 'img2.jpg',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Invitation à la Contemplation',
                'subtitle' => 'Cocody, Abidjan',
                'description' => 'Basé à Cocody, Abidjan, il conçoit chaque œuvre comme une invitation à la contemplation et à la découverte.',
                'image' => 'img1.jpg',
                'order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($slides as $slide) {
            CarouselSlide::create($slide);
        }
    }
}

