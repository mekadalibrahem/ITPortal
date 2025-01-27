<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RequestLog extends Model
{
    use HasFactory;


    protected $fillable = [
        "request_list_id",
        "employee_id",
        "create_at",
        "update_at"
    ];


    public function requestList():BelongsTo {
        return $this->belongsTo(RequestList::class);
    }

    public function employee():BelongsTo {
        return $this->belongsTo(Employee::class);
    }
}
