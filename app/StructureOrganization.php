<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StructureOrganization extends Model
{
    protected $table = 'structures';

    protected $fillable = ['name', 'position', 'thumbnail'];
}
