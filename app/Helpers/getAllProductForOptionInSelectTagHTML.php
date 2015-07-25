<?php
function getAllProductForOptionInSelectTagHTML($dataArray, $select = 0)
{
    $result = null;
    if(empty($dataArray)){
        return null;
    }
    foreach ($dataArray as $k => $value) {
            $id = $value['id'];
            if ($select != 0 && $id == $select) {
                $result .= "<option value='" . $value['id'] . "' selected='selected'>" . $value['name_product']."|" .$value['key_product'] . "</option>";
            } else {
                $result .= "<option value='" . $value['id'] . "'>"  . $value['name_product']."|" .$value['key_product']. "</option>";
            }
        }
    return $result;
}
