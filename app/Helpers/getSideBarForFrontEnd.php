<?php

function getSideBarForFrontEnd($menuConvert, $parent = 0, &$result, $display=""){
    if(isset($menuConvert[$parent])){
        $i = 0;
        foreach($menuConvert[$parent] as $key=> $value){
            $i++;
            $id = $value['id'];
            if($parent == 0){
                $display = "style='display: block;'";
                if(isset($menuConvert[$value['id']])){
                    $result.= " <li class='list-group-item clearfix dropdown'>";
                    $result.=  "<a class='collapsed'><i class='fa fa-bars'></i>". $value['category_name']. "</a>";
                    getSideBarForFrontEnd($menuConvert, $id, $result, $display);
                    $result.= "</li>";
                }else{
                    $result.= " <li class='list-group-item clearfix'>";
                    $result.=  "<a class='collapsed'><i class='fa fa-minus'></i>". $value['category_name']. "</a>";
                    getSideBarForFrontEnd($menuConvert, $id, $result);
                    $result.= "</li>";
                }
            }else {
                if($i == 1) {
                    $result.="<ul class='dropdown-menu' $display>";
                }
                $changeAliasNamCategory = change_alias($value['category_name']);
                $linkCategory = $changeAliasNamCategory."-".$value['id'];
                if(isset($menuConvert[$value['id']])){
                    $result.= "<li class='list-group-item dropdown clearfix'>";
                    $result.=  "<a href='".action('FrontendController@showProductByCategory',$linkCategory)."'><i class='fa fa fa-bars'></i>". $value['category_name']. "</a>";
                    getSideBarForFrontEnd($menuConvert, $id, $result);
                    $result.= "</li>";
                }else{
                    $result.= "<li class='list-group-item clearfix'>";
                    $result.=  "<a href='".action('FrontendController@showProductByCategory',$linkCategory)."'><i class='fa fa-minus'></i>". $value['category_name']. "</a>";
                    getSideBarForFrontEnd($menuConvert, $id, $result);
                    $result.= "</li>";
                }
            }

        }
        if($parent != 0){
            $result.= "</ul>";
        }

    }

}
