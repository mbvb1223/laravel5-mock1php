<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class City extends Model {
    protected $guarded = ['id'];
    protected $table = 'city';
    public $properties = array('id','name_city','created_at','updated_at');
    public $timestamps = true;

    public static function mapIdCityToInfoCity(){
        $citys = self::all()->toArray();
        if($citys == null){
            return null;
        }
        foreach($citys as $city){
            $mapIdCityToInfoCity[$city['id']] = $city;
        }
        return $mapIdCityToInfoCity;
    }

    public static function getViewSelectTagCity($idSelected=0){
        $citys = self::all()->toArray();
        $result="";
        foreach($citys as $city){
            if($idSelected !=0 && $city['id']==$idSelected){
                $result.="<option value='".$city['id']."' selected='selected'>$city[name_city]</option>";
            }else {
                $result.="<option value='".$city['id']."'>$city[name_city]</option>";
            }

        }
        return $result;
    }

}

