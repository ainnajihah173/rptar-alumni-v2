<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\Message;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Share $inboxCount with the staff-base layout
        View::composer('layouts.staff-base', function ($view) {
            $inboxCount = Message::where('receiver_id', auth()->id())
                ->where('is_read', 0) // Assuming 0 means unread
                ->count();
            $view->with('inboxCount', $inboxCount);
        });

        // // Share $inboxCount with the staff-base layout
        // View::composer('message.index', function ($view) {
        //     $count = Message::where('receiver_id', auth()->id())
        //         ->where('is_read', 0) // Assuming 0 means unread
        //         ->count();
        //     $view->with('count', $count);
        // });
    }
}
