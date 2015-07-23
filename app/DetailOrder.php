<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class DetailOrder extends Model {
    protected $guarded = ['id'];
    protected $table = 'detail_order';
    public $timestamps = true;


    public function getViewAllDetailOrderByIdOrder($getAllDetailOrderByIdOrder){
        $result = "";
        foreach($getAllDetailOrderByIdOrder as $item){
            $totalCost = $item['cost'] * $item['number'];
            $action ="action";
            $result .= "<tr>
                <td>
                    <span class='label label-sm label-success'>
                        Available
                    </span>
                </td>
                <td>
                    <a href='#'>$item[id] </a>
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
                        $item[cost]
                </td>
                 <td>
                        $totalCost
                </td>
                 <td>
                        $action
                </td>

            </tr>";
        }
        return $result;

    }


}



