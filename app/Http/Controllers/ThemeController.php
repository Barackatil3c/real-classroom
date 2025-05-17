<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class ThemeController extends Controller
{
    public function switch(Request $request)
    {
        $theme = $request->input('theme', 'light');
        
        if (!in_array($theme, ['light', 'dark'])) {
            $theme = 'light';
        }

        Cookie::queue('theme', $theme, 60 * 24 * 30); // 30 days

        return back();
    }
} 