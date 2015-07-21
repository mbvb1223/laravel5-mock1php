<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class DetailOrder extends Model {
    protected $guarded = ['id'];
    protected $table = 'detail_order';
    public $timestamps = true;



}



