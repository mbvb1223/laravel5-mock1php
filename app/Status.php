<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Status extends Model
{
    protected $guarded = ['id'];
    protected $table = 'status';
    public $properties = array('id', 'name_status');
    public $timestamps = true;


}

