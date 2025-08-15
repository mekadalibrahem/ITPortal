<?php

namespace App\Models;

use App\Models\RequestTemplates\RequestTemplateStep;
use App\Traits\ModelHelper\HasDateTimeCast;
use App\Traits\ModelHelper\HasEndAt;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RequestLog extends Model
{
    use HasFactory;
    use HasEndAt;
    use HasDateTimeCast;

    protected $fillable = [
        "request_list_id",
        "employee_id",
        "request_tamplates_step_id",
        "note",
        "start_at",
        'end_at',
        "create_at",
        "update_at"
    ];
    protected $casts = [
        'start_at' => 'date:d/m/Y',
        'end_at' => 'date:d/m/Y',
        "created_at" => 'date:d/m/Y',
        "updated_at" => 'date:d/m/Y'
    ];
   
    public function step(): BelongsTo
    {
        return $this->belongsTo(RequestTemplateStep::class, 'request_tamplates_step_id');
    }


    public function requestList(): BelongsTo
    {
        return $this->belongsTo(RequestList::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
