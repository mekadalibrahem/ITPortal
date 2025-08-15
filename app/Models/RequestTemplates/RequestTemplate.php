<?php

namespace App\Models\RequestTemplates;

use App\Models\RequestList;
use App\Models\Requests;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RequestTemplate extends Model
{
    use HasFactory;

    protected $table = 'request_templates';

    protected $fillable = [
        'id',
        'name',
        'description',
        'created_at',
        'updated_at'
    ];


    public function request_list(): HasMany
    {
        return $this->hasMany(RequestList::class);
    }
    public function request(): HasMany
    {
        return $this->hasMany(Requests::class);
    }

    public function order_steps(): HasMany
    {
        return $this->hasMany(OrderStep::class);
    }

    public function steps(): BelongsToMany
    {
        return $this->belongsToMany(
            RequestTemplateStep::class,
            OrderStep::class,
            'request_template_id',
            'request_tamplates_steps_id'
        );
    }
}
