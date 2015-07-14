<?php
function getAllMadein($dataArray, $select = 0, &$result)
{
    foreach ($dataArray as $k => $value) {
            $id = $value['id'];
            if ($select != 0 && $id == $select) {
                $result .= "<option value='" . $value['id'] . "' selected='selected'>" . $value['madein_name'] . "</option>";
            } else {
                $result .= "<option value='" . $value['id'] . "'>"  . $value['madein_name'] . "</option>";
            }
        }
}
