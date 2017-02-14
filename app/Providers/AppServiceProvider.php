<?php

namespace App\Providers;

use App\Events\ChatMessageEvent;
use Event;
use App\ChatMessage;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        ChatMessage::created(function($mes){
            Event::fire(new ChatMessageEvent($mes));
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
