<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('page_marques_contents', function (Blueprint $table) {
            $table->id();

            // Banner Section
            $table->text('banner_default_description')->nullable();
            $table->string('banner_background')->nullable();

            // Introduction
            $table->string('intro_title')->nullable();
            $table->text('intro_text')->nullable();

            // Grid Section
            $table->string('grid_title')->default('Nos Produits');
            $table->text('grid_subtitle')->nullable();

            // Product Card Buttons
            $table->string('product_button_whatsapp')->default('Commander sur WhatsApp');

            // Modal Detail
            $table->string('detail_button_whatsapp')->default('Commander sur WhatsApp');
            $table->string('detail_characteristics_title')->default('Caractéristiques');
            $table->string('detail_label_material')->default('Matière');
            $table->string('detail_label_color')->default('Couleur');
            $table->string('detail_label_brand')->default('Marque');
            $table->string('detail_label_availability')->default('Disponibilité');

            // Modal Order
            $table->string('order_title')->default('Commander');
            $table->string('order_label_name')->default('Nom');
            $table->string('order_label_email')->default('Email');
            $table->string('order_label_phone')->default('Téléphone');
            $table->string('order_label_message')->default('Message');
            $table->string('order_button_submit')->default('Commander via Email');
            $table->string('order_button_whatsapp')->default('Continuer sur WhatsApp');

            // WhatsApp Message Template (⚠️ corrigé ici)
            $table->text('whatsapp_message_template')->nullable();

            // Meta SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_marques_contents');
    }
};
