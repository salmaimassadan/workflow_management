<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            $user = Auth::guard('employee')->user();
            $unreadNotificationsCount = 0;

            if ($user) {
                $unreadNotificationsCount = Notification::where('user_id', $user->id)
                    ->where('read_status', 0)
                    ->count();
            }

            $view->with('unreadNotificationsCount', $unreadNotificationsCount);
        });
    }
}
