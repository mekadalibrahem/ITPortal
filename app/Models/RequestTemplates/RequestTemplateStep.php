<?php

namespace App\Models\RequestTemplates;

use App\Models\Department;
use App\Models\RequestList;
use App\Models\RequestLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RequestTemplateStep extends Model
{
    protected $table = 'request_tamplates_steps';

    protected $fillable = [
        'id',
        'name',
        'description',
        'role',
        'department_id',
        'created_at',
        'updated_at'
    ];


    public function request_list_logs(): HasMany
    {
        return $this->hasMany(RequestLog::class);
    }
    public function order_steps(): HasMany
    {
        return $this->hasMany(OrderStep::class);
    }
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function templates(): BelongsToMany
    {
        return $this->belongsToMany(
            RequestTemplate::class,
            OrderStep::class, 
            'request_tamplates_steps_id' ,
            'request_template_id'
        );
    }
    public function request_list() : HasMany {
        return $this->hasMany(RequestList::class , 'current_step_id');
    }
}
