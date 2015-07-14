<?php
function getAllMaterial($dataArray, $select = 0, &$result)
{
    foreach ($dataArray as $k => $value) {
            $id = $value['id'];
            if ($select != 0 && $id == $select) {
                $result .= "<option value='" . $value['id'] . "' selected='selected'>" . $value['material_name'] . "</option>";
            } else {
                $result .= "<option value='" . $value['id'] . "'>"  . $value['material_name'] . "</option>";
            }
        }
}
