<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PageContentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // HOME PAGE
        DB::table('page_home_contents')->insert([
            'hero_image' => 'img2.jpg',
            'hero_title' => 'Frederic N\'DA',
            'hero_paragraph_1' => 'Artiste peintre et designer ivoirien, Frederic N\'DA développe un univers artistique où la peinture contemporaine dialogue avec le design mobilier.',
            'hero_paragraph_2' => 'Son travail explore les formes, les textures et les couleurs, créant des pièces uniques qui transcendent les frontières entre l\'art et le fonctionnel.',
            'hero_paragraph_3' => 'Basé à Cocody, Abidjan, il conçoit chaque œuvre comme une invitation à la contemplation et à la découverte.',
            'about_title' => 'À Propos de l\'Artiste',
            'about_description' => 'Artiste peintre et designer basé en Côte d\'Ivoire, Frederic N\'DA combine tradition africaine et modernité dans ses œuvres. Son approche unique mêle couleurs vibrantes et compositions audacieuses.',
            'features_title' => 'Mes Domaines d\'Expression',
            'features_description' => 'De la peinture au design, explorez les différentes facettes de ma créativité',
            'cta_title' => 'Commandez Votre Œuvre Personnalisée',
            'cta_description' => 'Contactez-moi pour discuter de votre projet artistique sur mesure',
            'cta_button_text' => 'Me Contacter',
            'cta_button_link' => '/contact',
            'meta_title' => 'Frederic N\'DA - Artiste Peintre & Designer | Côte d\'Ivoire',
            'meta_description' => 'Portfolio officiel de Frederic N\'DA, artiste peintre et designer ivoirien. Découvrez mes œuvres, créations design et la galerie NÈGRE Workshop.',
            'meta_keywords' => 'frederic nda, artiste peintre, designer, côte d\'ivoire, art africain, peinture contemporaine',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // PEINTURE PAGE
        DB::table('page_peinture_contents')->insert([
            'banner_title' => 'Peinture',
            'banner_description' => 'Collection de peintures originales',
            'intro_title' => 'Mes Œuvres Picturales',
            'intro_text' => 'Chaque toile raconte une histoire, chaque couleur porte une émotion. Découvrez ma collection de peintures originales.',
            'grid_title' => 'Œuvres Disponibles',
            'grid_subtitle' => 'Explorez ma galerie de peintures',
            'product_button_order' => 'Commander',
            'detail_button_order' => 'Commander cette œuvre',
            'detail_characteristics_title' => 'Caractéristiques',
            'detail_label_dimensions' => 'Dimensions',
            'detail_label_technique' => 'Technique',
            'detail_label_support' => 'Support',
            'detail_label_year' => 'Année',
            'order_title' => 'Commander',
            'order_label_name' => 'Nom',
            'order_label_email' => 'Email',
            'order_label_phone' => 'Téléphone',
            'order_label_message' => 'Message',
            'order_button_submit' => 'Commander via Email',
            'order_button_whatsapp' => 'Continuer sur WhatsApp',
            'meta_title' => 'Peintures de Frederic N\'DA | Collection Originale',
            'meta_description' => 'Découvrez la collection de peintures originales de Frederic N\'DA. Œuvres contemporaines mêlant tradition africaine et modernité.',
            'meta_keywords' => 'peinture, art contemporain, œuvres originales, frederic nda, art africain',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // DESIGN PAGE
        DB::table('page_design_contents')->insert([
            'banner_title' => 'Design',
            'banner_description' => 'Créations design uniques et innovantes',
            'intro_title' => 'Design & Créativité',
            'intro_text' => 'Du mobilier aux objets décoratifs, découvrez mes créations design qui allient esthétique et fonctionnalité.',
            'grid_title' => 'Créations Design',
            'grid_subtitle' => 'Parcourez mes réalisations design',
            'product_button_order' => 'Commander',
            'detail_button_order' => 'Commander cette pièce',
            'detail_characteristics_title' => 'Caractéristiques',
            'detail_label_dimensions' => 'Dimensions',
            'detail_label_materials' => 'Matériaux',
            'detail_label_finish' => 'Style',
            'detail_label_year' => 'Année',
            'order_title' => 'Commander',
            'order_label_name' => 'Nom',
            'order_label_email' => 'Email',
            'order_label_phone' => 'Téléphone',
            'order_label_message' => 'Message',
            'order_button_submit' => 'Commander via Email',
            'order_button_whatsapp' => 'Continuer sur WhatsApp',
            'meta_title' => 'Design par Frederic N\'DA | Créations Uniques',
            'meta_description' => 'Explorez les créations design de Frederic N\'DA. Mobilier, objets décoratifs et pièces uniques alliant art et fonctionnalité.',
            'meta_keywords' => 'design, mobilier design, objet déco, frederic nda, design africain',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // GALLERY PAGE
        DB::table('page_gallery_contents')->insert([
            'banner_title' => 'NÈGRE Workshop Gallery',
            'banner_subtitle' => 'LE NÈGRE | workshop - gallery',
            'banner_description' => 'Un espace inspirant dédié à la création artistique, aux événements et aux échanges culturels.',
            'banner_quote' => 'Est un atelier artistique fondé par l\'artiste peintre Frederic N\'DA aka \'le nègre\', cet espace inspirant destiné à sa pratique artistique, à la créativité, aux petits événements artistiques et aux podcasts où d\'autres créateurs et artistes pourront raconter leurs histoires et leurs approches artistiques.',
            'gallery_name' => 'Gallery',
            'gallery_description' => 'NÈGRE Workshop - Espace créatif',
            'tab_atelier' => 'L\'Atelier',
            'tab_activites' => 'Activités',
            'tab_evenements' => 'Événements',
            'tab_podcasts' => 'Podcasts',
            'modal_details_title' => 'Détails',
            'modal_label_type' => 'Type',
            'modal_label_frequency' => 'Fréquence',
            'modal_label_capacity' => 'Capacité',
            'modal_label_audience' => 'Public',
            'modal_button_whatsapp' => 'Réserver sur WhatsApp',
            'whatsapp_message_template' => 'Bonjour, je souhaite réserver : {activity_title}',
            'meta_title' => 'NÈGRE Workshop Gallery | Espace Artistique & Culturel',
            'meta_description' => 'NÈGRE Workshop Gallery, l\'atelier de Frederic N\'DA. Espace dédié à la création, aux événements artistiques et aux échanges culturels.',
            'meta_keywords' => 'atelier artistique, galerie, événements culturels, podcasts art, côte d\'ivoire',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // CONTACT PAGE
        DB::table('page_contact_contents')->insert([
            'banner_title' => 'Contactez-nous',
            'banner_description' => 'N\'hésitez pas à nous contacter pour toute question ou demande',
            'info_title' => 'Informations de Contact',
            'info_email' => 'contact@fredericnda.com',
            'info_phone' => '+225 07 69 46 59 04',
            'info_address' => 'Abidjan',
            'info_city' => 'Abidjan',
            'info_country' => 'Côte d\'Ivoire',
            'social_facebook' => 'https://facebook.com/fredericnda',
            'social_instagram' => 'https://instagram.com/fredericnda',
            'social_twitter' => 'https://twitter.com/fredericnda',
            'social_linkedin' => 'https://linkedin.com/in/fredericnda',
            'form_title' => 'Envoyez-nous un message',
            'form_description' => 'Remplissez le formulaire ci-dessous et nous vous répondrons dans les plus brefs délais',
            'meta_title' => 'Contact | Frederic N\'DA',
            'meta_description' => 'Contactez Frederic N\'DA pour vos projets artistiques, commandes personnalisées ou demandes d\'information.',
            'meta_keywords' => 'contact, frederic nda, commande art, projet artistique',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // MARQUES PAGE
        DB::table('page_marques_contents')->insert([
            'banner_default_description' => 'Découvrez nos collections de produits uniques',
            'intro_title' => 'Nos Collections',
            'intro_text' => 'Parcourez nos différentes marques et collections de produits artistiques et design.',
            'grid_title' => 'Nos Produits',
            'grid_subtitle' => 'Sélectionnez votre article favori',
            'product_button_whatsapp' => 'Commander sur WhatsApp',
            'detail_button_whatsapp' => 'Commander sur WhatsApp',
            'detail_characteristics_title' => 'Caractéristiques',
            'detail_label_material' => 'Matière',
            'detail_label_color' => 'Tailles disponibles',
            'detail_label_brand' => 'Style',
            'detail_label_availability' => 'Collection',
            'order_title' => 'Commander',
            'order_label_name' => 'Nom',
            'order_label_email' => 'Email',
            'order_label_phone' => 'Téléphone',
            'order_label_message' => 'Message',
            'order_button_submit' => 'Commander via Email',
            'order_button_whatsapp' => 'Continuer sur WhatsApp',
            'whatsapp_message_template' => 'Bonjour, je souhaite commander le produit suivant : {product_name} au prix de {product_price}. Merci de me recontacter.',
            'meta_title' => 'Marques & Collections | Frederic N\'DA',
            'meta_description' => 'Découvrez les collections et marques proposées par Frederic N\'DA. Produits artistiques et créations design.',
            'meta_keywords' => 'marques, collections, produits art, design, frederic nda',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // MODAL CONTENTS (Textes des modales réutilisables)
        DB::table('modal_contents')->insert([
            // Modal Details
            'detail_characteristics_title' => 'Caractéristiques',
            'detail_button_order' => 'Commander',
            'detail_button_reserve' => 'Réserver sur WhatsApp',
            
            // Modal Order
            'order_title' => 'Commander',
            'order_label_name' => 'Nom',
            'order_label_email' => 'Email',
            'order_label_phone' => 'Téléphone',
            'order_label_message' => 'Message',
            'order_button_submit' => 'Envoyer',
            
            // Messages
            'success_message' => 'Votre commande a été prise en compte avec succès.',
            'success_submessage' => 'Un email de confirmation vous sera envoyé sous peu.',
            'loading_title' => 'Envoi en cours...',
            'loading_message' => 'Veuillez patienter pendant que nous traitons votre demande.',
            
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

