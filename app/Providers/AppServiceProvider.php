<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
        // Partager les variables globales avec toutes les vues
        view()->composer('*', function ($view) {
            $view->with('whatsappNumber', config('services.whatsapp.number'));
            $view->with('emailjsConfig', [
                'publicKey' => config('services.emailjs.public_key'),
                'serviceId' => config('services.emailjs.service_id'),
                'templateId' => config('services.emailjs.template_id'),
                'templateAdminId' => config('services.emailjs.template_admin_id'),
            ]);
            $view->with('adminEmail', config('services.admin.email'));
            $view->with('adminName', config('services.admin.name'));
            // Partager le contenu des modales avec toutes les vues
            $view->with('modalContent', \App\Models\ModalContent::first());
        });
    }
}
