<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cookie;

class ThemeServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        View::composer('*', function ($view) {
            $theme = Cookie::get('theme', config('theme.default'));
            $themes = config('theme.themes');
            
            $view->with([
                'currentTheme' => $theme,
                'themeColors' => $themes[$theme],
            ]);
        });
    }
} 