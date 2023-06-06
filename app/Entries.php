<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entries extends Model
{
    protected $fillable = [
        'code', 
        'entry_school',
        'entry_name',
        'age',
        'category',
    ];
}
