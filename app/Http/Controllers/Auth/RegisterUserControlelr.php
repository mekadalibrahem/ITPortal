<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Classes\Services\Actions\UserAction;

class RegisterUserControlelr extends Controller
{
    /**
     * show register view
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * handle request to register new user
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'fname' => ['required', 'string', 'max:255'],
            'mname' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'nid' => ['required', 'string', 'max:255'],
            "username" =>  ['required', 'string', 'max:255', 'unique:users,username'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],

            'password' => ['required', 'min:8', 'same:confirm_password'],
        ]);

        $user = UserAction::register([
            'fname' => $request->fname,
            'mname' => $request->mname,
            'lname' => $request->lname,
            'username' => $request->username,
            'email' => $request->email,
            "national_id" => $request->nid,
            'password' => $request->password
        ], [
            'student'
        ]);


        event(new Registered($user));
        Auth::login($user);

        return redirect(route('home'));
    }
}
