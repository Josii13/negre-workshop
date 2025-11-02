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
        Schema::create('page_peinture_contents', function (Blueprint $table) {
            $table->id();
            // Banner Section
            $table->string('banner_title')->default('Peinture');
            $table->text('banner_description')->nullable();
            $table->string('banner_background')->nullable();
            
            // Introduction
            $table->string('intro_title')->nullable();
            $table->text('intro_text')->nullable();
            
            // Grid Section
            $table->string('grid_title')->default('Mes Œuvres');
            $table->text('grid_subtitle')->nullable();
            
            // Product Card Buttons
            $table->string('product_button_order')->default('Commander');
            
            // Modal Detail
            $table->string('detail_button_order')->default('Commander cette œuvre');
            $table->string('detail_characteristics_title')->default('Caractéristiques');
            $table->string('detail_label_dimensions')->default('Dimensions');
            $table->string('detail_label_technique')->default('Technique');
            $table->string('detail_label_support')->default('Support');
            $table->string('detail_label_year')->default('Année');
            
            // Modal Order
            $table->string('order_title')->default('Commander');
            $table->string('order_label_name')->default('Nom');
            $table->string('order_label_email')->default('Email');
            $table->string('order_label_phone')->default('Téléphone');
            $table->string('order_label_message')->default('Message');
            $table->string('order_button_submit')->default('Commander via Email');
            $table->string('order_button_whatsapp')->default('Continuer sur WhatsApp');
            
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
        Schema::dropIfExists('page_peinture_contents');
    }
};

