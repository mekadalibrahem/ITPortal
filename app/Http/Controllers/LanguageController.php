<?php

namespace App\Http\Controllers;

use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LanguageController extends Controller
{
    public function switch(Request $request)
    {
        $request->validate([
            'language' => 'required'
        ]);
        Debugbar::info("LanguageController@switch :  language parameter is "  . $request->language);
        session()->put(['language' => $request->language]);
        session()->save();

        return redirect()->back();
    }
}
