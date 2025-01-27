<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasFactory;


    protected $fillable = [
        "id",
        "content",
        "from_id",
        "user_id",
        "note",
        "create_at",

    ];


    public function user():BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function is_read():bool{
        return !empty($this->read_at) ;
    }
    public function date(){
        return Carbon::parse($this->create_at)->format('Y-m-d');
    }
    public function sender() :User {
        $sender = User::where("id" , "=" , $this->from_id)->first();
        return $sender ;
    }
    public function mark_read(){
        $this->read_at = Carbon::now();
        $this->save();

    }
        /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
