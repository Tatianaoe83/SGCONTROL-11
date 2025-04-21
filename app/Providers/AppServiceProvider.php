<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use BezhanSalleh\FilamentLanguageSwitch\LanguageSwitch;
use Livewire\Livewire;
use App\Http\Livewire\ChatBotComponent;

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
        LanguageSwitch::configureUsing(function (LanguageSwitch $switch) {
            $switch
                ->displayLocale('es') 
                ->locales(['es','en']) 
                ->visible(outsidePanels: true);
        });

        Livewire::component('chat-bot-component', ChatBotComponent::class);
    }
}
