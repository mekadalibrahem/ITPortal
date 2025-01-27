<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class RegisterUserControlelr extends Controller
{
    /**
     * show register view
     */
    public function create():View
    {
        return view('auth.register');
    }

    /**
     * handle request to register new user
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'fname' => ['required' , 'string' , 'max:255']  ,
            'mname' => ['required' , 'string' , 'max:255']  ,
            'lname' => ['required' , 'string' , 'max:255']  ,
            'nid' => ['required' , 'string' , 'max:255']  ,
            "username" =>  ['required' , 'string' , 'max:255' , 'unique:users,username' ]  ,
            'email' => ['required' , 'string' , 'email' , 'max:255' , 'unique:users,email'],

            'password' => ['required' , 'min:8' , 'same:confirm_password'],
            "type" => ['required' ],
        ]);

        if($request->type == 1 || $request->type == 2){
            //  dd($request->type);
            $user = User::create([
                'fname'=> $request->fname ,
                'mname'=> $request->mname ,
                'lname'=> $request->lname ,
                'username'=> $request->username ,
                'email'=> $request->email ,
                "national_id" => $request->nid ,
                'password'=> Hash::make($request->password)
            ]);

            // dd($user);
            try {
                if($request->type == 1){
                    $user->assignRole('student');
                }elseif($request->type==2){
                    $user->assignRole('employee_requests');
                }
            } catch (\Throwable $th) {
                Log::warning("Can't find role  for assign to user");
            }

            event(new Registered($user));
            Auth::login($user);

            return redirect(route('home' ));
        }else{
            return redirect()->back();
        }

    }
}
