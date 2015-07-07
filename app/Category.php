<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Category extends Model {
    protected $guarded = ['id'];
    protected $table = 'category';
    public $properties = array('id','category_name','parent','created_at','updated_at');
}

