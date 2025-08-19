<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Data extends Model
{
    use HasFactory;

    protected $fillable = [
        "id",
        "name",
        "value",
        "request_list_id"
    ];

    public function request_list(): BelongsTo{
        return $this->belongsTo(Requests::class);
    }
    public function require_data() : HasOne {
        return $this->hasOne(RequireData::class , 'name_en' , 'name');
    }
    public function type() {
        // $required_data = RequireData::where("name_en" , "=" , $this->name)->first();
        return $this->require_data->type ;
    }
}
