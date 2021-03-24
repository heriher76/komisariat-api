<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ebook extends Model
{
    protected $fillable = ['name', 'by', 'file', 'category', 'thumbnail'];
}
