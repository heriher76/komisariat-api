<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InfoTraining extends Model
{
    protected $table = 'info_training';

    protected $fillable = ['title', 'date_start', 'date_end', 'province', 'url', 'thumbnail'];
}
