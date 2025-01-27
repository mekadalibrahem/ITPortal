<?php

namespace App\Http\Controllers;

use App\Models\RequestList;
use App\Models\RequestType;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class RequestTypeController extends Controller
{
    use AuthorizesRequests;
    // public function __construct()
    // {
    //     $this->authorizeResource(RequestList::class , 'request_types');
    // }

    public  function viewany(){
        return $this->authorize( 'viewany' , RequestType::all());
    }

}
