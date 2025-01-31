<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Requests extends Model
{
    use HasFactory;
    // protected $tabel = "requests";


    protected $fillable = [
        'id',
        'name',
        'type_id',
        'isActive',
        'to_department'
    ];


    public function type():BelongsTo {
        return $this->belongsTo(RequestType::class);
    }

    public function requestList():HasMany {
        return $this->hasMany(RequestList::class);
    }

    public function requireData() : HasMany {
        return $this->hasMany(RequireData::class);
    }
    public function department( ) :BelongsTo {
        return $this->belongsTo(Department::class, 'to_department');
    }

    /**
     * scope retrun just active itme
     */
    public function scopeActive(Builder $query) :void {
        $query->where('isActive' , "=" , 1) ;
    }



        /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
