<?php
function getAllColorForOptionInSelectTagHTML($dataArray, $select = 0)
{
    $result = null;

    if(empty($dataArray)){
        return null;
    }

    foreach ($dataArray as $k => $value) {
        $id = $value['id'];
        if ($select != 0 && $id == $select) {
            $result .= "<option value='" . $value['id'] . "' selected='selected'>" . $value['color_name'] . "</option>";
        } else {
            $result .= "<option value='" . $value['id'] . "'>"  . $value['color_name'] . "</option>";
        }
    }
    return $result;
}
