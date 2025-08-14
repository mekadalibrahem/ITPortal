<?php


namespace App\Traits\ModelHelper;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasDateTimeCast
{

    protected function startAt(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? \Carbon\Carbon::parse($value)->format('d/m/Y') : null,
        );
    }
    protected function endAt(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? \Carbon\Carbon::parse($value)->format('d/m/Y') : null,
        );
    }
    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? \Carbon\Carbon::parse($value)->format('d/m/Y') : null,
        );
    }

    protected function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? \Carbon\Carbon::parse($value)->format('d/m/Y') : null,
        );
    }
}
