<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserHasGroup extends Model
{
    protected $table = 'users_has_group';
    protected $fillable = ['id_user', 'id_group', 'is_admin'];
}
