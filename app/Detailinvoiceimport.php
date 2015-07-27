<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Detailinvoiceimport extends Model
{
    protected $guarded = ['id'];
    protected $table = 'detail_invoice_import';
    public $properties = array('id', 'product_id', 'color_id', 'size_id', 'number', 'price_import', 'created_at', 'updated_at');
    public $timestamps = true;


    public function getViewAllDetailInvoiceImportByIdInvoiceImport($getAllDetailInvoiceImportByIdInvoiceImport)
    {
        $mapIdColorToInformationColor = Color::mapIdColorToInformationColor();
        $mapIdSizeToInformationSize   = Size::mapIdSizeToInformationSize();
        $result                       = null;
        foreach ($getAllDetailInvoiceImportByIdInvoiceImport as $item) {
            $totalCost = number_format($item['price_import'] * $item['number'], 2);
            $nameColor = $mapIdColorToInformationColor[$item['color_id']]['color_name'];
            $sizeValue = $mapIdSizeToInformationSize[$item['size_id']]['size_value'];
            $priceImport = number_format($item['price_import'],2);
            $result .= "<tr>
                <td>
                    $item[product_id] | $item[name_product] | $item[key_product]
                </td>

                <td>
                    $nameColor
                </td>
                <td>
                    $sizeValue
                </td>
                <td>
                    $item[number]
                </td>
                <td>
                    $$priceImport
                </td>
                 <td>
                    $$totalCost
                </td>
            </tr>";
        }
        return $result;
    }
}



