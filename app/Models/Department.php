<?php

namespace App\Models;

use App\Traits\DepartmentManagmentTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    use HasFactory;
    use DepartmentManagmentTrait ;


    protected $fillable = [
        "id",
        "name",
        "description",
        "manager_id"
    ];

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }

    public function manager(): BelongsTo
    {
        return $this->BelongsTo(Employee::class, 'manager_id');
    }

    public function requests(): HasMany
    {
        return $this->hasMany(Requests::class, 'to_department');
    }

    public function get_employees_id()
    {
        $emps = $this->employees;
        $id_list = [];
        foreach ($emps as $employee) {
            $id_list[] = $employee->id;
        }
        return $id_list;
    }

    public function get_user_manager()
    {
        if ($this->manager_id == null) {
            return null ;
        }else{
            $emp = Employee::where('id' , '=' , $this->manager_id)->first();
            return $emp->user ;
        }
    }
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
