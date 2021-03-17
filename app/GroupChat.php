<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupChat extends Model
{
    protected $table = 'groupchats';

    protected $fillable = ['name', 'admin_group'];

    public function users()
    {
        return $this->belongsToMany('App\User', 'users_has_group', 'id_group', 'id_user');
    }

    public function admin()
    {
        return $this->belongsTo('App\User', 'admin_group');
    }

    public function messages()
    {
        return $this->hasMany('App\Message', 'id_group');
    }
}
