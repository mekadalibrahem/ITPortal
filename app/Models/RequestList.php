<?php

namespace App\Models;

use App\Enums\RequestStatusEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\RequestTemplates\RequestTemplate;
class RequestList extends Model
{
    use HasFactory;

    // protected $table  = 'request_lists' ;
    protected $fillable = [
        "id",
        "user_id",
        "request_id",
        "request_template_id",
        'status',
        'note',
        'dean',
        'coordinator',
        'create_at',
        'update_at',
    ];


    public function template(): BelongsTo {
        return $this->belongsTo(RequestTemplate::class);
    }

    public function requests(): BelongsTo
    {
        return $this->belongsTo(Requests::class, 'request_id', 'id');
    }

    public function data(): HasMany
    {
        return $this->hasMany(Data::class, 'request_list_id', 'id');
    }

    public function requestLog(): HasMany
    {
        return $this->hasMany(RequestLog::class);
    }
    public function scopeLive(Builder $query): void
    {

        $query->whereIn('status', [
            RequestStatusEnum::WATING->value,
            RequestStatusEnum::WORKING->value,
            RequestStatusEnum::CHECKING->value,
            RequestStatusEnum::DRAFT->value,

        ]);
    }

    public function employees(): BelongsToMany
    {
        return $this->belongsToMany(Employee::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function canDelete()
    {
        return ($this->status == RequestStatusEnum::DRAFT) ? true : false;
    }
    public function can_edit()
    {
        if (
            $this->status == RequestStatusEnum::DRAFT->value ||
            $this->status == RequestStatusEnum::WATING->value ||
            $this->status == RequestStatusEnum::CHECKING->value
        ) {
            return true;
        } else {
            return false;
        }
    }

}
