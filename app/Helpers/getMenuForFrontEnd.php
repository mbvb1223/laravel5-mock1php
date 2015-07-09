<?php


//function callMenu($menuConvert, $parent=0, &$result){
//    if(isset($menuConvert[$parent])){
//        $result.= "<ul class='dropdown-menu' >";
//        foreach($menuConvert[$parent] as $value){
//            $id = $value['id'];
//            $result.= "<li>";
//            $result.=  "<a href=''>". $value['category_name']. "</a>";
//            callMenu($menuConvert, $id, $result);
//            $result.=  "</li>";
//        }
//        $result.=  "</ul>";
//    }
//}


function callMenu($menuConvert, $parent=0, &$result){
    if(isset($menuConvert[$parent])){
        foreach($menuConvert[$parent] as $key=> $value){
            $numberInArray = count($menuConvert[$parent])-1;
            if($parent==0){
                $id = $value['id'];
                $result.= "<li class='dropdown'>";
                $result.=  "<a class='dropdown-toggle' data-toggle='dropdown' data-target='#' href='#'>". $value['category_name']. "</a>";
                callMenu($menuConvert, $id, $result);
                $result.= "</li>";
            }else {
                $id = $value['id'];
                if($key==0){
                   $result.= "<ul class='dropdown-menu'>";
                }
                if(isset($menuConvert[$value['id']])){
                    $result.= "<li class='dropdown-submenu'>";
                    $result.=  "<a href=''>". $value['category_name']. "</a><i class='fa fa-angle-right'></i>";
                    callMenu($menuConvert, $id, $result);
                    $result.= "</li>";
                }else {
                $result.= "<li>";
                $result.=  "<a href=''>". $value['category_name']. "</a>";
                $result.= "</li>";
                callMenu($menuConvert, $id, $result);
                }
            }
            if($parent!=0){
                if($key==$numberInArray){
                    $result.= "</ul>";
                }
            }

        }
    }
//    if($parent==0){
//        $result.= "</li>";
//    }
}

//function callMenu($menuConvert, $parent=0, &$result){
//    if(isset($menuConvert[$parent])){
//        foreach($menuConvert[$parent] as $key=> $value){
//            $numberInArray = count($menuConvert[$parent])-1;
//            if($parent==0){
//                $id = $value['id'];
//                $result.= "<li class='dropdown'>";
//                $result.=  "<a class='dropdown-toggle' data-toggle='dropdown' data-target='#' href='#'>". $value['category_name']. "</a>";
//                callMenu($menuConvert, $id, $result);
//            }else {
//
//                $id = $value['id'];
//                if($key==0){
//                    $result.= "<ul class='dropdown-menu'>";
//                }
//
//                $result.= "<li>";
//                $result.=  "<a href=''>". $value['category_name']. "</a>";
//                $result.= "</li>";
//                callMenu($menuConvert, $id, $result);
//
//            }
//            if($parent!=0){
//                if($key==$numberInArray){
//                    $result.= "</ul>";
//                }
//            }
//
//        }
//    }
//    if($parent==0){
//        $result.= "</li>";
//    }
//}


//
//function callMenu($menuConvert, $parent=0, &$result){
//    if(isset($menuConvert[$parent])){
//        foreach($menuConvert[$parent] as $key=> $value){
//            if($parent==0){
//                $id = $value['id'];
//                $result.= "<li class='dropdown'>";
//                $result.=  "<a href=''>". $value['category_name']. "</a>";
//                callMenu($menuConvert, $id, $result);
//            }else {
//
//                $id = $value['id'];
//                if($key==0){
//                    $result.= "<ul class='dropdown-menu'>";
//                }
//
//                $result.= "<li>";
//                $result.=  "<a href=''>". $value['category_name']. "</a>";
//                $result.= "</li>";
//                callMenu($menuConvert, $id, $result);
//
//            }
//            if($key==0){
//                $result.= "</ul>";
//            }
//        }
//    }
//    if($parent==0){
//        $result.= "</li>";
//    }
//}