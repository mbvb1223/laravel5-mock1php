<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Selloff extends Model {
    protected $guarded = ['id'];
    protected $table = 'selloff';
    public $properties = array('id','selloff_value','created_at','updated_at');
    public $timestamps = true;


    /**
     * getData for pagination using ajax bootgrid
     * @param $dataRequest
     * @param $config
     * @return mixed
     */

    public function getDataForPaginationAjax($dataRequest,$config){
        // Config sort
        $sortBy = 'id';
        $sortOrder = 'asc';
        if(isset($dataRequest['sort'])) {
            $sort = $dataRequest['sort'];
            $sortColum = ['id','selloff_value','created_at','updated_at'];
            $sortBy = (in_array(key($sort), $sortColum)) ? key($sort) : 'id';
            $sortOrder = current($sort);
        }

        $query = $this->where('id', 'LIKE', '%'.$dataRequest['searchPhrase'].'%')
            ->orWhere('selloff_value', 'LIKE', '%'.$dataRequest['searchPhrase'].'%')
            ->orWhere('created_at', 'LIKE', '%'.$dataRequest['searchPhrase'].'%')
            ->orWhere('updated_at', 'LIKE', '%'.$dataRequest['searchPhrase'].'%')
        ;
        $queryGetTotal = $query;
        $total = $queryGetTotal->count();

        if($config['limit']== -1){
            $rows = $query->orderBy($sortBy, $sortOrder)
                          ->get();
        }else {
            $rows = $query->orderBy($sortBy, $sortOrder)
                ->skip($config['offset'])
                ->take($config['limit'])
                ->get();
        }
        return ['total'=> $total, 'rows'=>$rows];
    }

    public static function getViewAllSellOffForSelectTag($idSelected = 0)
    {
        $all = self::all()->toArray();
        $result = "<option value='0'> None </option> ";
        foreach ($all as $item) {
            if ($idSelected != 0 && $item['id'] == $idSelected) {
                $result .= "<option value='" . $item['id'] . "' selected='selected'> $item[selloff_value] </option> ";
            } else {
                $result .= "<option value='" . $item['id'] . "'> $item[selloff_value] </option> ";
            }
        }
        return $result;
    }
}

