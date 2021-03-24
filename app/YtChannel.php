<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class YtChannel extends Model
{
    protected $table = 'ytchannels';

    protected $fillable = ['title', 'thumbnail', 'url'];
}
