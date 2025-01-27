<?php


/**
 * just for testing route will not used in projects
 */

use App\Classes\exportPdf;
use App\Models\Data;
use App\Models\Department;
use App\Models\Employee;
use App\Models\RequestList;
use App\Models\RequestLog;
use App\Models\Requests;

use Illuminate\Support\Facades\Route;

use App\Models\User;

/**
 * SELECT request_lists.id AS 're_ls_id',requests.name AS're_name',departments.name AS 'dep_name',departments.manager_id AS 'MSN', users.id AS 'user_id' ,request_lists.status, users.email , employees.id AS 'EMPLOYEE_ID' , departments.id AS 'DEP_ID' , request_logs.id AS 'log_id' FROM users JOIN employees ON users.id = employees.user_id JOIN departments ON employees.department_id = departments.id JOIN request_logs ON employees.id = request_logs.employee_id JOIN request_lists ON request_logs.request_list_id = request_lists.id JOIN requests ON requests.id = request_lists.request_id
 */
Route::prefix('/test')->group(function () {

    Route::view('/table', 'test.table');
    Route::view('/layout', 'test.layout');

    Route::get('/d', function () {
        $re = Requests::where('id', '=', 5)->first();
        return $re->department->manager_id;
    });

    Route::get('/sm', function () {
      // get user ;
      $req = RequestList::where('id', '=',7   )->first();
      $user =$req->user ;
      $req_data  = $req->date ;
      $re_type = Requests::where('id' , "=" , $req->request_id)->first();

      $dep = Department::where("id" , "=" , $re_type->to_department)->first();
      $dep_manager = Employee::where("id" , '=' , $dep->manager_id )->first();
      $dep_manager_name = $dep_manager->user->fname . " " .$dep_manager->user->lname ;


      $data_view = [
          "id" => $req->id ,
          "date" => $req->created_at->format('Y-m-d') ,
          "dean" => $req->dean ,
          "dep_name" => $dep->name ,
          "dep_manager" => $dep_manager_name,
          'data' => exportPdf::get_request_data($re_type->id ,$req , $user),
      ];
      return view("pdfs.5" , $data_view);
    });

    Route::get("/data", function () {
        $ed = Data::find(36);
        $ed->value = "va";
        $ed->save();
    });
});






Route::get('/test/users', function () {
    return User::all();
});
