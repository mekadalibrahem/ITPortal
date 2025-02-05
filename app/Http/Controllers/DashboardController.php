<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(){
        $user = Auth::user();

        if($user->hasRole('admin')){
           return "admin";
        }else if ($user->hasRole('employee')){
            return "employee";
        }else{
            abort(401);
        }
    }
}
