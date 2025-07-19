<?php

namespace App\Models\RequestTemplates;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class OrderStep extends Model
{
    protected $table = 'order_steps';

    protected $fillable = [
        'id',
        'request_tamplates_steps_id',
        'request_template_id',
        'order',
        'created_at',
        'updated_at'
    ];

    public function step(): BelongsTo
    {
        return $this->belongsTo(RequestTemplateStep::class);
    }
    public function template(): BelongsTo
    {
        return $this->belongsTo(RequestTemplate::class);
    }
}
