<?php
function convertStringUrlToId($stringid)
{
    $arrayStringId = explode('-', $stringid);
    $idProduct     = intval(array_pop($arrayStringId));
    return $idProduct;
}
