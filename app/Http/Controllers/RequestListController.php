<?php

namespace App\Http\Controllers;


class RequestListController extends Controller
{

    public function create(){
        return view('user.requests');
    }
    public function index($id){
        return "show request ifnormation [" . $id ."]"  ;
    }
    public function add(){
        return "show add new request "  ;
    }
}
