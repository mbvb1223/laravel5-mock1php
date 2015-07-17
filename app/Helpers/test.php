<?php
/**
 * @param $dataArrayCategory
 * @param int $parent
 * @param string $text
 * @param int $select
 * @return string
 */
function test($dataArrayCategory,$id, &$result)
{
    foreach ($dataArrayCategory as $value) {
        if($value['id']==$id){
            if($value['parent'] == 0){
                break;
            }
            $result[] = $value['parent'];
            test($dataArrayCategory,$value['parent'],$result);
        }

    }

}


