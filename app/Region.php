<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Region extends Model {
    protected $guarded = ['id'];
    protected $table = 'region';
    public $properties = array('id','name_region','city_id','ship_money','created_at','updated_at');
    public $timestamps = true;

    public static function mapIdRegionToInfoRegion(){
        $regions = self::all()->toArray();
        if($regions == null){
            return null;
        }
        foreach($regions as $region){
            $mapIdRegionToInfoRegion[$region['id']] = $region;
        }
        return $mapIdRegionToInfoRegion;
    }

    public static function mapIdCityToArrayRegion(){
        $regions = self::all()->toArray();
        if($regions == null){
            return null;
        }
        foreach($regions as $region){
            $mapIdCityToArrayRegion[$region['city_id']][] = $region;
        }
        return $mapIdCityToArrayRegion;
    }

    public static function getViewSelectTagRegion($idSelected=0){
        $regions = self::all()->toArray();
        $result="";
        foreach($regions as $region){
            if($idSelected !=0 && $region['id']==$idSelected){
                $result.="<option value='".$region['id']."' selected='selected'>$region[name_region]</option>";
            }else {
                $result.="<option value='".$region['id']."'>$region[name_region]</option>";
            }

        }
        return $result;
    }


}

