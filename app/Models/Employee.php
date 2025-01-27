<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;


class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        "id",
        "user_id",
        "department_id"
    ];


    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function manage(): HasOne
    {
        return $this->hasOne(Department::class, 'manager_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function requestLog(): HasMany
    {
        return $this->HasMany(RequestLog::class);
    }

    public function requestList(): BelongsToMany
    {
        return $this->belongsToMany(RequestList::class);
    }
    public function scopeFree(Builder $query): void
    {
        $query->where(
            'department_id',
            "=",
            null
        );
    }
    public function scopeManager(Builder $quere): void
    {

        $quere->whereIn(
            "id",
            Department::get('manager_id')
        );
    }

    public function is_manager(): bool
    {


        $dep  = $this->department;
        return  (bool) ($dep->manager_id == $this->id);
    }
    public  function get_request_log_ids()
    {

        if ($this->is_manager()) {
            $dep = $this->department;

            $emps = $dep->get_employees_id();

            $logs = RequestLog::whereIn("employee_id", $emps)->get();

            $logs_id = [];
            foreach ($logs as $log) {
                $logs_id[] = $log->id;
            }
            return array_unique($logs_id);
        } else {

            $logs = RequestLog::where("employee_id", '=', $this->id)->get();
            $logs_id = [];
            foreach ($logs as $log) {
                $logs_id[] = $log->id;
            }
            return array_unique($logs_id);
        }
    }

    public function manager()
    {
        $dep = $this->department;
        $emps = Employee::where("id", "=", $dep->manager_id)->first();
        return $emps;
    }
    public function dep_name(){
        $dep = $this->department;
        if($dep){
            return $dep->name;
        }else{
            return null ;
        }
    }

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
