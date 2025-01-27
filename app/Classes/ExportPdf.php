<?php

namespace App\Classes;


use App\Models\Department;
use App\Models\Employee;
use App\Models\Requests;
use Illuminate\Support\Facades\File;
use Spatie\Browsershot\Browsershot;

class ExportPdf
{

    private const MAP  = [
        1 => "pdfs.1",
        2 => "pdfs.2",
        5 => "pdfs.5",


    ];


    public static function export($req, $data)
    {

        // get user ;
        $user = $req->user;
        $req_data  = $req->data;


        $re_type = Requests::where('id', "=", $req->request_id)->first();
        $dep = Department::where("id", "=", $re_type->to_department)->first();
        $dep_manager = Employee::where("id", '=', $dep->manager_id)->first();
        $dep_manager_name = $dep_manager->user->fname . " " . $dep_manager->user->lname;

        $data_view = [
            "logo" => self::logo_to_base64(),
            "id" => $req->id,
            "date" => $req->created_at->format('Y-m-d'),
            "dean" => $req->dean,
            "dep_name" => $dep->name,
            "dep_manager" => $dep_manager_name,
            'user_name' => $user->fname . " " . $user->lname,
            'mname' => $user->mname,
            'data' => self::get_request_data($re_type->id, $req_data, $user)
        ];

        $file_name = $user->fullname() . "_" . $re_type->name . "_" . $req->id . "_" . time() . ".pdf";
        $htmlContent = view(self::get_view_name($re_type->id), $data_view)->render();
        Browsershot::html($htmlContent)
            ->waitUntilNetworkIdle()
            ->savePdf($file_name);
        return response()->download($file_name)->deleteFileAfterSend(true);
    }

    public static function logo_to_base64($path = 'imgs/albaath_logo.png')
    {
        $imagePath = public_path($path);
        $imageData = base64_encode(file_get_contents($imagePath));
        $src = 'data:image/png;base64,' . $imageData;
        return $src;
    }

    public static function get_view_name($id)
    {
        return  "pdfs.$id";

        if (isset(self::MAP[$id])) {
            return self::MAP[$id];
        } else {
            throw new \Exception("INVALID REQUEST NAME");
        }
    }

    public static function get_request_data($id, $data, $user)
    {
        // dd($data);
        $array  = [];
        foreach ($data as $item) {
            // dd($item);
            $array[$item->name] = $item->value;
        }
        return $array;
        // switch ($id) {
        //     case 5:
        //         return self::get_request_5_data($data, $user);
        //         break;
        // }
    }
    private static function get_request_5_data($data, $user)
    {

        $sp = ' ';
        $ac = '';
        foreach ($data as  $i) {
            if ($i->name == "specialization") {
                $sp = $i->value;
            }
            if ($i->name == 'academic_year') {
                $ac = $i->value;
            }
        }


        return  [
            'specialization' => $sp,
            'academic_year' => $ac,
            'user_name' => $user->fname . " " . $user->lname,
            'mname' => $user->mname,

        ];
    }

    public static function All_photos()
    {
        return        File::allFiles(public_path('uploads/request_photos'));
    }
}
