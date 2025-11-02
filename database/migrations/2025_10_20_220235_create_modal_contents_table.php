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
        Schema::create('modal_contents', function (Blueprint $table) {
            $table->id();
            $table->string('detail_characteristics_title')->default('Caractéristiques');
            $table->string('detail_button_order')->default('Commander');
            $table->string('detail_button_reserve')->default('Réserver sur WhatsApp');
            $table->string('order_title')->default('Commander');
            $table->string('order_label_name')->default('Nom');
            $table->string('order_label_email')->default('Email');
            $table->string('order_label_phone')->default('Téléphone');
            $table->string('order_label_message')->default('Message');
            $table->string('order_button_submit')->default('Envoyer');

            // ⚠️ Colonnes TEXT → pas de valeur par défaut
            $table->text('success_message')->nullable();
            $table->text('success_submessage')->nullable();
            $table->string('loading_title')->default('Envoi en cours...');
            $table->text('loading_message')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modal_contents');
    }
};
