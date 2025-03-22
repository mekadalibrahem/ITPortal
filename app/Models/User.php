<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\UserManagmentTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use HasRoles;
    use UserManagmentTrait;

    /**
     * The attributes that are mass assignable
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'fname',
        'lname',
        'mname',
        'username',
        'national_id',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public  const   GENERAL_INFO = [
        'id',
        'fname',
        'mname',
        'lname',
        'email',
        'username',
        'national_id',
    ];


    public function fullname(): string{
        return $this->fname . ' ' . $this->mname . ' ' . $this->lname;
    }


    public function employee() : HasOne {
        return $this->hasOne(Employee::class);
    }

    public function requestList() :HasMany {
        return $this->hasMany(RequestList::class);
    }

    public function notifications() : HasMany {
        return $this->hasMany(Notification::class);
    }
    public function hasAdminRole() {
        // $roles  = $this->roles ;
        // foreach ($roles as $role) {
        //     if ( preg_match( '/^admin/' , $role->name)) {
        //         return true ;
        //     }
        // }

        return true ;
    }

    public function generalInfo(){

    }

}
