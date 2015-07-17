<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Color extends Model {
    protected $guarded = ['id'];
    protected $table = 'color';
    public $properties = array('id','color_name','created_at','updated_at');
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
            $sortColum = ['id','color_name','created_at','updated_at'];
            $sortBy = (in_array(key($sort), $sortColum)) ? key($sort) : 'id';
            $sortOrder = current($sort);
        }

        $query = $this->where('id', 'LIKE', '%'.$dataRequest['searchPhrase'].'%')
            ->orWhere('color_name', 'LIKE', '%'.$dataRequest['searchPhrase'].'%')
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

    public function mapIdToInfoColor(){
        $allColor = self::all();
        $newArray = null;
        foreach($allColor as $color){
            $newArray[$color['id']] = $color;
        }
        return $newArray;
    }

    public static function mapIdColorToInformationColor(){
        $colors = self::all()->toArray();

        if($colors == null){
            return null;
        }
        foreach($colors as $color){
            $mapIdColorToInformationColor[$color['id']] = $color;
        }
        return $mapIdColorToInformationColor;
    }

}

