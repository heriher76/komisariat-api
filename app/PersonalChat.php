<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonalChat extends Model
{
    protected $table = 'personalchats';

    protected $fillable = ['id_user', 'id_receiver'];

    public function user()
    {
        return $this->belongsTo('App\User', 'id_user');
    }

    public function receiver()
    {
        return $this->belongsTo('App\User', 'id_user');
    }

    public function messages()
    {
        return $this->hasMany('App\Message', 'id_personal');
    }
}
