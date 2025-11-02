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
        Schema::create('page_contact_contents', function (Blueprint $table) {
            $table->id();
            // Banner Section
            $table->string('banner_title')->default('Contactez-nous');
            $table->text('banner_description')->nullable();
            $table->string('banner_background')->nullable();
            
            // Contact Info
            $table->string('info_title')->default('Informations de Contact');
            $table->string('info_email')->nullable();
            $table->string('info_phone')->nullable();
            $table->string('info_address')->nullable();
            $table->string('info_city')->nullable();
            $table->string('info_country')->nullable();
            
            // Social Media
            $table->string('social_facebook')->nullable();
            $table->string('social_instagram')->nullable();
            $table->string('social_twitter')->nullable();
            $table->string('social_linkedin')->nullable();
            
            // Form Section
            $table->string('form_title')->default('Envoyez-nous un message');
            $table->text('form_description')->nullable();
            
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
        Schema::dropIfExists('page_contact_contents');
    }
};

