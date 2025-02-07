<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(){
        $user = Auth::user();
        if($user->hasRole('employee')){
            return redirect()->route('employee.requests');
        }else if ($user->hasRole('admin')){
            return redirect()->route('admin.staticties');
        }else{
            abort(403);
        }
    }
}
