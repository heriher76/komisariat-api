<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements AuthenticatableContract, AuthorizableContract, JWTSubject
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'hp', 'department', 'address', 'photo', 'komisariat', 'gcmtoken', 'sex', 'age', 'jenjang_training', 
        'pengalaman_organisasi', 'linkedin', 'instagram', 'other_social_media', 'year_join', 'angkatan_kuliah'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //Fix no role named blabla
    protected $guard_name = 'api';

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function personalChats()
    {
        return $this->hasMany('App\PersonalChat', 'id_user');
    }

    public function groups()
    {
      return $this->belongsToMany('App\GroupChat', 'users_has_group', 'id_user', 'id_group');
    }

    public function adminGroups()
    {
        return $this->hasMany('App\GroupChat', 'admin_group');
    }
}
