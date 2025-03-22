<?php

namespace App\Models;

use App\Traits\EmployeeManagmentTrait;
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

    use EmployeeManagmentTrait ;

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

    public function scopeCanManager(Builder $quere, $department_id): void
    {
        $quere->where(
            'department_id',
            "=",
            null
        )
            ->orWhere(
                'department_id',
                '=',
                $department_id
            );
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

    

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
