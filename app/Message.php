<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'message', 'id_user', 'id_group', 'id_personal'
    ];

    public function user()
    {
      return $this->belongsTo('App\User', 'id_user');
    }

    public function groupChat()
    {
      return $this->belongsTo('App\GroupChat', 'id_group');
    }

    public function personalChat()
    {
      return $this->belongsTo('App\PersonalChat', 'id_personal');
    }
}
