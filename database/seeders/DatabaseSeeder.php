<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Créer un super admin par défaut
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@negreshop.com',
            'password' => bcrypt('password'),
            'type' => 'super_admin',
            'email_verified_at' => now(),
        ]);

        // Créer un admin par défaut
        User::create([
            'name' => 'Admin',
            'email' => 'admin@negreshop.com',
            'password' => bcrypt('password'),
            'type' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Appeler tous les seeders dans l'ordre
        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
            CarouselSlideSeeder::class,
            ActivitySeeder::class,
            SiteSettingSeeder::class,
            PageContentsSeeder::class,
            MarqueCategorySeeder::class,
            MarqueProductsSeeder::class,
        ]);
    }
}
