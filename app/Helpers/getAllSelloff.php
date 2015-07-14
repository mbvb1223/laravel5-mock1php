<?php
function getAllSelloff($dataArray, $select = 0, &$result)
{
    foreach ($dataArray as $k => $value) {
            $id = $value['id'];
            if ($select != 0 && $id == $select) {
                $result .= "<option value='" . $value['id'] . "' selected='selected'>" . $value['selloff_value'] . "</option>";
            } else {
                $result .= "<option value='" . $value['id'] . "'>"  . $value['selloff_value'] . "</option>";
            }
        }
}
