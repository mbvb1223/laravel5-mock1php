<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Madein extends Model {
    protected $guarded = ['id'];
    protected $table = 'madein';
    public $properties = array('id','madein_name','created_at','updated_at');
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
            $sortColum = ['id','madein_name','created_at','updated_at'];
            $sortBy = (in_array(key($sort), $sortColum)) ? key($sort) : 'id';
            $sortOrder = current($sort);
        }

        $query = $this->where('id', 'LIKE', '%'.$dataRequest['searchPhrase'].'%')
            ->orWhere('madein_name', 'LIKE', '%'.$dataRequest['searchPhrase'].'%')
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

    public static function getViewAllMadeInForSelectTag($idSelected = 0)
    {
        $all = self::all()->toArray();
        $result   = null;
        foreach ($all as $item) {
            if ($idSelected != 0 && $item['id'] == $idSelected) {
                $result .= "<option value='" . $item['id'] . "' selected='selected'> $item[madein_name] </option> ";
            } else {
                $result .= "<option value='" . $item['id'] . "'> $item[madein_name] </option> ";
            }
        }
        return $result;
    }

    public static function arrayFromIdMadeinToNameMadein(){
        $all = self::all()->toArray();
        if($all == null){
            return null;
        }
        $newArray = array();
        foreach($all as $item){
            $newArray[$item['id']] = $item['madein_name'];
        }
        return $newArray;
    }

}

