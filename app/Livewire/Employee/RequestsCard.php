<?php

namespace App\Livewire\Employee;

use App\Classes\Export\BrowserShotExportRequest;
use App\Classes\Export\GrapesJsTemplateRenderer;
use App\Classes\ExportPdf;
use App\Classes\RequestManagment\RequestManagmentTemplate;
use App\Enums\RequestStatusEnum;
use App\Models\Employee;
use App\Models\Notification;
use App\Models\RequestList;
use Livewire\Component;
use App\Models\RequireData;
use Illuminate\Support\Facades\Auth;
use Masmerise\Toaster\Toaster;
use Spatie\Browsershot\Browsershot;

class RequestsCard extends Component
{
    public $id;
    public $hidden = true;
    public $request;
    public $request_id;
    public $request_data;
    public $status  = [];
    public $current_employee ;
    public $last_log;
    public $cancel_note;
    public $redirect_note  = null;
    public $request_user;
    public $can_work ;
    

    public  function accept()
    {
        $request_manager =  $this->getRequestManager();
       if($request_manager->hasNext()){
            $request_manager->next();
       }else{
         $request_manager->accept("تم قبول الطلب بنجاح");
       }
       Toaster::success("تم الموافقة على الطلب");
       redirect()->route('employee.requests');
    }
    public function  reject()
    {
        $this->validate([
            "cancel_note" => "required",
        ]);
        $request_manager =  $this->getRequestManager();
        $request_manager->reject($this->cancel_note);
        Toaster::success("تم رفض الطلب");
        redirect()->route('employee.requests');
    }

    public function cancel()
    {
        $this->validate([
            "cancel_note" => "required",
        ]);
        $request_manager =  $this->getRequestManager();
        $request_manager->sendToEdit($this->cancel_note);
        Toaster::success('تم طلب تعديل البيانات بنجاح');
        redirect()->route('employee.requests');
    }

   

    public function show()
    {

        $this->hidden = false;
        $this->request_id = $this->id;
        $this->request = RequestList::with(['data', 'user'])
            ->findOrFail($this->request_id);
        $requireDataMap = RequireData::whereIn(
            'name_en',
            $this->request->data->pluck('name')
        )->pluck('type', 'name_en'); // [ 'name_en' => 'type' ]

      
        $details = $this->request->data->map(function ($d) use ($requireDataMap) {
            return [
                'name'  => $d->name,
                'type'  => $requireDataMap[$d->name] ?? 'unknown', 
                'id'    => $d->id,
                'value' => $d->value,
            ];
        })->all();
        

        
        $this->request_data = $details;
        $this->request_user = $this->request->user; 
    }



    public function mount()
    {
        $this->current_employee = Employee::where('user_id', Auth::id())->first();
        $this->show();
        $this->can_work_in_request();
      
       

    }
    public function can_work_in_request(){
        $log = $this->request->requestLog->where('request_tamplates_step_id' , $this->request->current_step_id)->first();
        $isCurrentEmployee = $log->employee_id == $this->current_employee->id ? true : false ;
        $is_end = $this->request->end_at != null ? true : false;
        if($is_end  || !$isCurrentEmployee){
            $this->can_work = false;
        }else{
            $this->can_work= true;
        }
    }
    private function getRequestManager(){
        $request_managment_template = new RequestManagmentTemplate();
        $request_managment_template->setEmployee($this->current_employee);
        $request_managment_template->setRequestList($this->request);
        return $request_managment_template ;
    }

    public function exportToPdf()
    {   $request = RequestList::where('id', $this->request->id)->with(
        [
            'user',
            'requestLog.employee.user',
            'requests',
        ]
        )->first();
        $browser_shot = new  BrowserShotExportRequest(new GrapesJsTemplateRenderer(), $request);
        return  $browser_shot->export();

    }
    public function render()
    {
      
        return view('livewire.employee.requests-card');
    }
}
