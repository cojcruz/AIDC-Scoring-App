<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entries extends Model
{
    protected $fillable = [
        'code', 
        'entry_school_id',
        'entry_name',
        'category',
    ];
}
