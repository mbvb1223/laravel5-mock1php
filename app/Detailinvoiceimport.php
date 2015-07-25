<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Detailinvoiceimport extends Model {
    protected $guarded = ['id'];
    protected $table = 'detail_invoice_import';
    public $properties = array('id','product_id','color_id','size_id','number','price_import','created_at','updated_at');
    public $timestamps = true;


    public function getViewAllDetailInvoiceImportByIdInvoiceImport($getAllDetailInvoiceImportByIdInvoiceImport)
    {
        $result = null;
        foreach ($getAllDetailInvoiceImportByIdInvoiceImport as $item) {
            $totalCost = $item['price_import'] * $item['number'];
            $result .= "<tr>
                <td>
                    <a href='#'>$item[product_id] </a>
                </td>

                <td>
                        $item[color_id]
                </td>
                <td>
                       $item[size_id]
                </td>
                <td>
                        $item[number]
                </td>
                <td>
                        $$item[price_import]
                </td>
                 <td>
                        $$totalCost
                </td>
            </tr>";
        }
        return $result;
    }
}



