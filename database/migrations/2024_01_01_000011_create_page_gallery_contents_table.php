<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('page_gallery_contents', function (Blueprint $table) {
            $table->id();

            // Banner Section
            $table->string('banner_title')->default('NÈGRE Workshop Gallery');
            $table->string('banner_subtitle')->default('LE NÈGRE | workshop - gallery');
            $table->text('banner_description')->nullable();
            $table->text('banner_quote')->nullable();
            $table->string('banner_background')->nullable();

            // Gallery Card Section (Page d'accueil)
            $table->string('gallery_name')->default('Gallery');
            $table->text('gallery_description')->nullable();
            $table->string('gallery_image')->nullable();

            // Tabs Section
            $table->string('tab_atelier')->default('L\'Atelier');
            $table->string('tab_activites')->default('Activités');
            $table->string('tab_evenements')->default('Événements');
            $table->string('tab_podcasts')->default('Podcasts');

            // Modal Activity Details
            $table->string('modal_details_title')->default('Détails');
            $table->string('modal_label_type')->default('Type');
            $table->string('modal_label_frequency')->default('Fréquence');
            $table->string('modal_label_capacity')->default('Capacité');
            $table->string('modal_label_audience')->default('Public');
            $table->string('modal_button_whatsapp')->default('Réserver sur WhatsApp');

            // WhatsApp Message Template (⚠️ pas de valeur par défaut possible pour TEXT)
            $table->text('whatsapp_message_template')->nullable();

            // Meta SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_gallery_contents');
    }
};
