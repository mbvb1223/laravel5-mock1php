<?php
/**
 * @param array $dataArrayCategory
 * @param int $parent
 * @param string $text
 * @param int $select
 * @return string
 */
function getAllCategoryForSelectTag($dataArrayCategory, $parent = 0, $text = "", $select = 0, &$result)
{
    foreach ($dataArrayCategory as $k => $value) {
        if ($value['parent'] == $parent) {
            $id = $value['id'];
            if ($select != 0 && $id == $select) {
                $result .= "<option value='" . $value['id'] . "' selected='selected'>" . $text . $value['category_name'] . "</option>";
            } else {
                $result .= "<option value='" . $value['id'] . "'>" . $text . $value['category_name'] . "</option>";
            }
            unset($dataArrayCategory[$k]);
            getAllCategoryForSelectTag($dataArrayCategory, $id, $text . "--", $select, $result);
        }
    }

}


