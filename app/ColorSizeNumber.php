<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class ColorSizeNumber extends Model {
    protected $guarded = ['id'];
    protected $table = 'color_size_number';
    public $properties = array('id','product_id','color_id','size_id','number','created_at','updated_at');
    public $timestamps = true;

    public function arrayWithKeyAsColorSizeNumber(){
        $objColorSizeNumber = ColorSizeNumber::all()->toArray();

        if($objColorSizeNumber == null){
            $newArray = null;
            return $newArray;
        }
        foreach($objColorSizeNumber as $item){
            $productId = $item['product_id'];
            $colorId = $item['color_id'];
            $sizeId = $item['size_id'];
            $newkey = $productId ."|".$colorId."|".$sizeId;
            $newArray[$newkey] = $item;
        }
        return $newArray;
    }

    public static function arrayWithKeyAsProductColorSizeAndNumberBigerZero(){
        $objColorSizeNumber = self::where('number','>','0')->get()->toArray();
        if($objColorSizeNumber == null){
            $newArray = null;
            return $newArray;
        }
        foreach($objColorSizeNumber as $item){
            $productId = $item['product_id'];
            $colorId = $item['color_id'];
            $sizeId = $item['size_id'];
            $newkey = $productId ."|".$colorId."|".$sizeId;
            $newArray[$newkey] = $item;
        }
        return $newArray;
    }

    public static function mapIdProductToAllColorOfThisProduct(){
        $all = self::where('number', '>', 0)->get()->toArray();
        $objColor = new Color();
        $mapIdColorToInformationColor = $objColor->mapIdColorToInformationColor();

        $mapIdSizeToInformationSize = Size::mapIdSizeToInformationSize();
        if($all == null){
            return null;
        }
        foreach($all as $item){
            $mapIdProductToAllColorOfThisProduct[$item['product_id']][$item['color_id']] = $mapIdColorToInformationColor[$item['color_id']];


        }

        return $mapIdProductToAllColorOfThisProduct;

    }

    public static function mapIdColorToAllSizeOfThisProduct(){
        $all = self::where('number', '>', 0)->get()->toArray();

        $mapIdSizeToInformationSize = Size::mapIdSizeToInformationSize();
        if($all == null){
            return null;
        }
        foreach($all as $item){
            $mapIdColorToAllSizeOfThisProduct[$item['product_id']][$item['color_id']][$item['size_id']] = $mapIdSizeToInformationSize[$item['size_id']];
        }

        return $mapIdColorToAllSizeOfThisProduct;

    }

    public static function mapIdSizeToNumberOfThisColorAndThisProduct(){
        $all = self::where('number', '>', 0)->get()->toArray();

        if($all == null){
            return null;
        }
        foreach($all as $item){
            $mapIdSizeToNumberOfThisColorAndThisProduct[$item['product_id']][$item['color_id']][$item['size_id']] = $item['number'];
        }

        return $mapIdSizeToNumberOfThisColorAndThisProduct;

    }
}

