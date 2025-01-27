<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RequireData extends Model
{
    use HasFactory;

    protected $table = 'requier_data';

    protected $fillable = [
        'id',
        'name',
        'type',
        'request_id'
    ];

    public function request() :BelongsTo {
        return $this->belongsTo(Requests::class  );
    }
        /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
