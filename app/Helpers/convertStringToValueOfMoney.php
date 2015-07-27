<?php
function convertStringToValueOfMoney($money)
{
    $value = str_replace(',','',$money);
    $valueReturn = intval($value);
    return $valueReturn;
}
