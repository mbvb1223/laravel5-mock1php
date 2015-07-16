<?php
function convertAndSortByKeySessionCart($sessionCart)
{
    foreach ($sessionCart as $key => $itemCart) {
        $explodeKey = explode("|",$key);
        $newKey = $explodeKey[0]*100000 + $explodeKey[1]*100 + $explodeKey[2];
        $itemCart['key'] = $key;
        $returnArray[$newKey] = $itemCart;
    }
    ksort($returnArray);
    return $returnArray;
}
