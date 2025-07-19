<?php

namespace App\Models;

use App\Models\RequestTemplates\RequestTemplateStep;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RequestLog extends Model
{
    use HasFactory;


    protected $fillable = [
        "request_list_id",
        "employee_id",
        "request_tamplates_step_id",
        "note",
        "create_at",
        "update_at"
    ];


    public function step() : BelongsTo {
        return $this->belongsTo(RequestTemplateStep::class);
    }


    public function requestList():BelongsTo {
        return $this->belongsTo(RequestList::class);
    }

    public function employee():BelongsTo {
        return $this->belongsTo(Employee::class);
    }
}
