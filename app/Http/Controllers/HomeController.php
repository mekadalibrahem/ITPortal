<?php

namespace App\Http\Controllers;


use App\Models\Notification;
use App\Models\RequestList;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{


    public function create()
    {
        $user = Auth::user();

        /**
         * befor solve time for query
         */

        // $current_request = RequestList::live()->where(
        //     ['user_id' => $user->id],
        // )->get();

        // // dd($current_request);
        // $request_lists = [];
        // foreach ($current_request as $item) {
        //     $re = RequestList::find($item['id']);
        //     $re->requests;
        //     array_push($request_lists, $re);
        // }

        //after solve query
        // Eager load the 'requests' relationship and remove redundant queries
        $request_lists = RequestList::live()
        ->where('user_id', $user->id)
        ->with('requests') // ✅ Eager load relationships
        ->get();           // ✅ Single query

        // No loop needed! $request_lists already contains all data.
        $new_message = Notification::query()->where([
            'user_id' => $user->id
            // 'read_at' => null
        ])->get();

        // dd($request_lists);

        return view('user.home')->with([
            'request_list' => $request_lists,
            'user_id' => $user->id
        ]);
    }
}
