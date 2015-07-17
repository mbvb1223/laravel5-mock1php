<?php
function getAllSizeAndInputTagNumber($dataArray)
{
    $result = null;

    if(empty($dataArray)){
        $result .= "<tr><td colspan='4' class='text-center'>No results found!</td></tr>";
    }

    $i = -1; $j = 0;
    foreach ($dataArray as $key => $value) {
        $i++; $j++;

        if($i % 2 ==0){
            $result .= "<tr>";
        }

        $result .= "<td class='text-center'>";
        $result .= "$value[size_value]";
        $result .= "</td>";

        $result .= "<td class='text-center'>";
        $result .= "<input type='number' min='0' name='mapSizeToNumber[$value[id]]' class='form-control'>";
        $result .= "</td>";


        if($j % 2 ==0){
            $result .= "</tr>";
        }
    }
    return $result;
}
