<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;


class ProfileController extends Controller
{

    /**
     * show profile page
     */
    public function create(Request $request)
    {
        return view('user.profile');
    }

}
