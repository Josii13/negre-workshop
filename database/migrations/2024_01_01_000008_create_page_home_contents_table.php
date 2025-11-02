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
        Schema::create('page_home_contents', function (Blueprint $table) {
            $table->id();
            // Hero Section (Section avec image et texte en dessous du carousel)
            $table->string('hero_image')->default('img2.jpg');
            $table->string('hero_title')->default('Frederic N\'DA');
            $table->text('hero_paragraph_1')->nullable();
            $table->text('hero_paragraph_2')->nullable();
            $table->text('hero_paragraph_3')->nullable();
            
            // About Section
            $table->string('about_title')->default('À Propos');
            $table->text('about_description')->nullable();
            $table->string('about_image')->nullable();
            
            // Features Section
            $table->string('features_title')->default('Mes Domaines');
            $table->text('features_description')->nullable();
            
            // CTA Section
            $table->string('cta_title')->default('Commandez Votre Œuvre');
            $table->text('cta_description')->nullable();
            $table->string('cta_button_text')->default('Nous Contacter');
            $table->string('cta_button_link')->default('/contact');
            
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
        Schema::dropIfExists('page_home_contents');
    }
};

