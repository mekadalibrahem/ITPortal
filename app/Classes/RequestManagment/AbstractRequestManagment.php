<?php

namespace App\Classes\RequestManagment;

use App\Enums\RequestStatusEnum;
use App\Events\RequestListAskToEdit;
use App\Models\Employee;
use App\Models\Notification;
use App\Models\RequestList;
use Carbon\Carbon;

abstract class AbstractRequestManagment
{
    protected Employee $employee;
    protected RequestList $request_list;

    public function __construct() {}
    public function setEmployee(Employee $emp)
    {
        $this->employee = $emp;
    }
    public function getEmployee(): ?Employee
    {
        return $this->employee ?? null;
    }

    public function setRequestList(RequestList $req)
    {
        $this->request_list = $req;
    }
    public function getRequestList(): ?RequestList
    {
        return $this->request_list ?? null;
    }
    public function sendToEdit($message)
    {
        $req = $this->getRequestList();
        if ($req) {
            $req->status = RequestStatusEnum::WATING->value;
            if ($req->save()) {
                $this->setRequestList($req);
                $this->sendNotification($message);
                event(new RequestListAskToEdit( $req->id ,$req->current_step_id,$this->getEmployee()->user->email, $message));
                return true;
            }
        }
        return false;
    }

    public function sendNotification($message)
    {
        Notification::create([
            "content" => $message,
            "user_id" => $this->getRequestList()->user_id,
            "from_id" => $this->getEmployee()->user_id,
            'create_at' => Carbon::now()
        ]);
    }

    abstract function start();
    abstract function end($new_statues = RequestStatusEnum::END_ACCEPT->value, ?string $message = null);
    abstract function next();
    abstract function accept(?string $message = null);
    abstract function reject(?string $message = null);
    abstract function timeout();
    abstract function hasNext(): bool;
}
