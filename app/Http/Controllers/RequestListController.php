<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View ;

class RequestListController extends Controller
{

    public function create()
    {
        return view('user.requests');
    }
    public function index($id)
    {
        return view('requestlist.edit' , ['id' => $id]);
    }
    public function add(): View
    {
        return view('requestlist.create');
    }
}
