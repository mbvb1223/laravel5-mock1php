<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Detailinvoiceimport extends Model {
    protected $guarded = ['id'];
    protected $table = 'detail_invoice_import';
    public $properties = array('id','product_id','color_id','size_id','number','price_import','created_at','updated_at');
    public $timestamps = true;



}



