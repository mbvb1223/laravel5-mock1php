<?php
/**
 * Created by PhpStorm.
 * User: pckhien
 * Date: 7/4/15
 * Time: 1:59 PM
 */


function getAllCategory($data,$parent=0,$text="",$select=0){
    foreach($data as $k=>$value){
        if($value['parent'] == $parent){
            $id=$value['id'];
            if($select != 0 && $id == $select){
                echo "<option value='".$value['id']."' selected='selected'>".$text.$value['category_name']."</option>";
            }else{
                echo "<option value='".$value['id']."'>".$text.$value['category_name']."</option>";
            }
            unset($data[$k]);
            getAllCategory($data,$id,$text."--",$select);
        }
    }
}


